<html>
    <head></head>
    <body>
        <?php foreach($arrFiles as $file){ ?>
            <img src="<?=site_url()?>uploads/checkinlog/<?=$file?>" style="margin:10px" > 
        <?php };?>
    </body>
</html>