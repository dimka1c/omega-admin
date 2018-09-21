<div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-hover table-sm">
            <thead>
            <tr>
                <th scope="col">Имя</th>
                <th scope="col">Телефон</th>
                <th scope="col">Имя МЛ</th>
                <th scope="col">Авто</th>
                <th scope="col">Работает</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($drivers as $driver): ?>
                <tr>
                    <td><a href="/admin/edit-driver/<?=$driver['id']?>"><?= $driver['driver_name'] ?></a></td>
                    <td><?= $driver['driver_phone'] ?></td>
                    <td><?= $driver['driver_ml_name'] ?></td>
                    <?php if (!empty($driver['avto_number'])): ?>
                        <td><?= $driver['avto_number'] ?></td>
                    <?php else: ?>
                        <td><a href="/admin/edit-driver/<?=$driver['id']?>">Изменить</a></td>
                    <?php endif; ?>
                    <td><input class="form-check-input form-control-lg" type="checkbox" value="<?=$driver['driver_worked']?>" <?= $driver['driver_worked'] == 1 ? 'checked' : '' ?>></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>