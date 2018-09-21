<form>
    <div class="form-group">
        <label for="full-driver-name">ФИО</label>
        <input type="text" class="form-control" id="full-driver-name" value="<?= $carDataDriver['driver_name']?>">
    </div>
    <div class="form-group">
        <label for="driver-phone">Телефоны</label>
        <input type="text" class="form-control" id="driver-phone" value="<?= $carDataDriver['driver_phone']?>">
    </div>
    <div class="form-group">
        <label for="driver-ml-name">Имя для МЛ</label>
        <input type="text" class="form-control" id="driver-ml-name" value="<?= $carDataDriver['driver_ml_name']?>">
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="driver-worked">
        <label class="form-check-label" for="driver-worked">Водитель работает</label>
    </div>
    <?php
        $markaAuto = $carDataDriver['model_id'] ? $carDataDriver['decription'] . ' ' . $carDataDriver['avto_number'] . ' (' . $carDataDriver['avto_massa']. 'кг)' : 'Добавить авто';
    ?>
    <div class="row">
        <a href="/admin/edit-auto-driver/<?= $this->route['param'] ?>">
            <button type="button" class="btn btn-info" id="change-avto">
                <?= $markaAuto ?>
            </button>
        </a>

    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>
<div class="row">
    <a href="/admin/drivers">
        <button type="button" class="btn btn-primary">К списку водилетей</button>
    </a>
</div>
