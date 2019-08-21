<html>
    <head></head>
    <body>
        <?php foreach($arrFiles as $file){ ?>
            <div><img src="<?=site_url()?>uploads/checkinlog/<?=$file?>" ></div>
        <?php };?>
    </body>
</html>