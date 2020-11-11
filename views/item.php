<div class="items">
    <div class="itemHead">
        <div>
            <img src=<?= "../../images/" . $item['user_id'] . "/items" . "/". $item['photo'];?>>
        </div>
        <p><?= $item['name'];?></p>
    </div>

    <div class="prices">
        <div>
            <p>Aankoop</p>
            <p><?= "€ " . $item['ap'];?></p>
        </div>

        <div></div>

        <div>
            <p>Verkoop</p>
            <p><?= "€ " . $item['vp'];?></p>
        </div>
    </div>

</div>