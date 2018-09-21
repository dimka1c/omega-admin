<div class="container">
    <form action="/admin/edit-auto-driver" method="post">
        <input type="text" hidden name="id_driver" value="<?= $this->route['param']?>">
        <select class="form-control" name="select-auto">
            <?php foreach ($marka as $key => $val): ?>
                <option value="<?=$val['id']?>"><?= $val['decription'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for="massa">Грузоподъемность</label>
        <input class="form-control" type="text" id="massa" name="massa-auto">
        <label for="massa">Номер авто</label>
        <input class="form-control" type="text" id="number-auto" name="number-auto">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
