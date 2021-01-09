<h2><?= esc($title); ?></h2><br>
<div class="center">
    <?= \Config\Services::validation()->listErrors(); ?>
    <form action="/formations/create" method="post">
        <?= csrf_field() ?>
        <label for="name">Nom de la formation</label>
        <input type="input" name="name" /><br />

        <label for="duration_month">Durée de la formation en mois</label>
        <input type="number" name="duration_month" /><br />

        <label for="trainers">Formateurs</label>
        <input type="input" name="trainers" /><br />

        <label for="description">Description</label>
        <textarea name="description"></textarea><br />

        <label for="certified">Certifiable</label>
        <select name="certified" id="certified" required>
            <option value="1">Oui</option>
            <option value="0">Non</option>
        </select>
        <br>
        <br>
        <input class="pull-right" type="submit" name="submit" value="Create formation item" />
        <br>
        <br>
    </form>
</div>