<?php

namespace app\models;

use vendor\core\AppModel;

class MailModel extends AppModel
{

    public $mails = [];

    protected $mailCONST = [];

    protected $uploadFiles = [];

    public function __construct()
    {
        $this->mailCONST = require APP . '/app/config/email.config.php';
    }

    /*
     * функция разбора поля subject
     */
    private function explodeSubject(string $pattern, string $subj): bool
    {
        $subj = trim($subj);
        if (preg_match($pattern, $subj)) {
            return true;
        }
        return false;
    }


    private function create_part_array($structure, $prefix="") {
        //print_r($structure);
        global $part_array;
        if (sizeof($structure->parts) > 0) {    // There some sub parts
            foreach ($structure->parts as $count => $part) {
                $this->add_part_to_array($part, $prefix.($count+1), $part_array);
            }
        }else{    // Email does not have a seperate mime attachment for text
            $part_array[] = array('part_number' => $prefix.'1', 'part_object' => $obj);
        }
        return $part_array;
    }

    // Sub function for create_part_array(). Only called by create_part_array() and itself.
    private function add_part_to_array($obj, $partno, $part_array) {
        global $part_array;
        $part_array[] = array('part_number' => $partno, 'part_object' => $obj);
        if ($obj->type == 2) { // Check to see if the part is an attached email message, as in the RFC-822 type
            //print_r($obj);
            if (sizeof($obj->parts) > 0) {    // Check to see if the email has parts
                foreach ($obj->parts as $count => $part) {
                    // Iterate here again to compensate for the broken way that imap_fetchbody() handles attachments
                    if (sizeof($part->parts) > 0) {
                        foreach ($part->parts as $count2 => $part2) {
                            $this->add_part_to_array($part2, $partno.".".($count2+1), $part_array);
                        }
                    }else{    // Attached email does not have a seperate mime attachment for text
                        $part_array[] = array('part_number' => $partno.'.'.($count+1), 'part_object' => $obj);
                    }
                }
            }else{    // Not sure if this is possible
                $part_array[] = array('part_number' => $prefix.'.1', 'part_object' => $obj);
            }
        }else{    // If there are more sub-parts, expand them out.
            if (sizeof($obj->parts) > 0) {
                foreach ($obj->parts as $count => $p) {
                    $this->add_part_to_array($p, $partno.".".($count+1), $part_array);
                }
            }
        }
    }


    /*
     * Получение писем из почтового ящика
     *
     * @return array
     */

    public function getListEmail(): array
    {
        //$emailConst = require APP . '/app/config/email.config.php';
        //$ml = imap_open($emailConst['host'], $emailConst['username'], $emailConst['password']) or die('Cannot connect to: ' . $emailConst['host'] . '. <b>ERROR</b>' . imap_last_error());
        $ml = imap_open($this->mailCONST['host'], $this->mailCONST['username'], $this->mailCONST['password']) or die('Cannot connect to: ' . $this->mailCONST['host'] . '. <b>ERROR</b>' . imap_last_error());
        if($ml) {
            $n = imap_num_msg($ml); //колво писем в ящике
            if ($n > 0) {
                for ($i=1; $i<=$n; $i++) {
                    $h = imap_headerinfo($ml, $i);
                    $h = $h->from;
                    foreach ($h as $k => $v) {
                        $mailbox = $v->mailbox;
                        $host = $v->host;
                        $personal = $v->personal;
                        $email = $mailbox . '@' . $host;
                    }
                    $headerArr = imap_headerinfo($ml, $i);
                    $uid = imap_uid($ml, $headerArr->Msgno);
                    $this->mails[$uid]['from'] = $email;
                    $s = imap_fetch_overview($ml, $uid, FT_UID);
                    foreach ($s as $k => $v) {
                        $subj = imap_utf8($v->subject);
                        //if ($this->explodeSubject($this->mailCONST['patternSubj'], $subj)) {
                            $this->mails[$uid]['subj'] = $subj;
                            $this->mails[$uid]['message_date'] = $headerArr->date;
                            $this->mails[$uid]['size_message'] = $headerArr->Size;
                        //}
                    }
                }
            }
        }
        imap_close($ml);
        unset($ml);
        unset($headerArr);
        return $this->mails;
    }


    //*****************************************
    private static function isFileName($fname) {

        $f = substr($fname, 0, 2);
        if($f == 'ml') {
            return 1;
        }
        return 0;
    }



    protected function deleteAllFiles(string $dir): bool
    {
        $files = glob(APP . $dir .'/*');
        foreach ($files as $file) {
            if(is_file($file)) {
                unlink($file);
            }
        }
	return true;
    }


    public function loadAttach(int $uid): bool
    {
        $this->deleteAllFiles($this->mailCONST['files']['ATTACH']);
        $arr_attach = Array();

        set_time_limit(40000);

        $inbox = imap_open($this->mailCONST['host'], $this->mailCONST['username'], $this->mailCONST['password']) or die('Cannot connect to mailbox: ' . imap_last_error());
        $structure = imap_fetchstructure($inbox, $uid, FT_UID);
        $part_array = $this->create_part_array($structure);
        //$header = imap_fetchbody($inbox, $uid, '0', FT_UID);

        foreach ($part_array as $key => $attach) {
            if (($attach['part_object']->type == 3) &&
                (strtoupper($attach['part_object']->disposition) == 'ATTACHMENT') &&
                ($attach['part_object']->ifdparameters == 1) &&
                ((strtoupper($attach['part_object']->dparameters[0]->attribute) == 'FILENAME') OR
                    (strtoupper($attach['part_object']->dparameters[1]->attribute) == 'FILENAME'))
            ) {
                if (isset($attach['part_object']->dparameters)) {
                    foreach ($attach['part_object']->dparameters as $key => $fname) {
                        if (strtoupper($fname->attribute) == 'FILENAME') {
                            $this->structureKey = $key;
                            continue;
                        }
                    }
                }
                if ($this->structureKey == -1) {
                    echo 'Не возможно найти вложения. Программа завершена <br>';
                    exit;
                }
                $filename = $attach['part_object']->dparameters[$this->structureKey]->value;
                if (self::isFileName($filename) == 1) {
                    $file_attachment = imap_fetchbody($inbox, $uid, $attach['part_number'], FT_UID);
                    if ($attach['part_object']->encoding == 3) {
                        $file_attachment = base64_decode($file_attachment);
                    } elseif ($attach['part_object']->encoding == 4) {
                        $file_attachment = quoted_printable_decode($file_attachment);
                    }
                    $fp = fopen(APP . $this->mailCONST['files']['ATTACH'] . '/' . $filename, "w+");
                    fwrite($fp, $file_attachment);
                    fclose($fp);
                    unset($fp);
                    $file_attachment = null;
                    unset($file_attachment);
                    //$arr_attach[] = $filename;
                    $this->uploadFiles[] = $filename;
                }
            } //endif
        }
        imap_close($inbox);
        $file_attachment = null;
        unset($file_attachment);
        $filename = null;
        unset($filename);
        $attach = null;
        unset($attach);
        $part_array = null;
        unset($GLOBALS['part_array']);
        $structure = null;
        unset($structure);
        $inbox = null;
        unset($inbox);

        //return $arr_attach;
        return true;
    }


}