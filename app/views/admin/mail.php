<h1>Работа с почтой</h1>

<div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-hover table-sm">
            <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Автор</th>
                <th scope="col">Тема</th>
                <th scope="col">Размер</th>
                <th scope="col">Дата</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allEmail as $key => $email): ?>
                <tr>
                    <th scope="row"><?= $key ?></th>
                    <td><?= $email['from'] ?></td>
                    <td><?= $email['subj'] ?></td>
                    <td><?= $email['size_message'] ?></td>
                    <td><?= $email['message_date'] ?></td>
                    <td><button type="button" class="btn btn-outline-success" id="id_email_<?= $key ?>" name="name_email_<?= $key ?>">Создать МЛ</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="/js/mail.js"></script>