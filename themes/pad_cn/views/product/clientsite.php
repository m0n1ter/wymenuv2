    <div class="client_category_title">临时台</div>
    <ul>
        <li class="siteaction bg_add" istemp="1" status="0" sid="0"></li>
        <?php foreach ($models_temp as $mt):?>
        <li class="siteaction <?php if($mt->status=='1') echo 'bg-yellow'; elseif($mt->status=='2') echo 'bg-blue'; elseif($mt->status=='3') echo 'bg-green';?>" istemp="1" status=<?php echo $mt->status;?> sid=<?php echo $mt->site_id;?> shname="<?php echo $mt->site_id%1000;?>"><span style="font-size: 25px;"><?php echo $mt->site_id%1000;?>&nbsp;</span><br><?php echo $mt->create_at;?></li>
        <?php endforeach;?>    
          
    </ul>
    <div class="client_line"></div>
    
    <?php foreach ($models_category as $mc):?>
        <div class="client_category_title">临时台</div>
        <?php foreach ($mc->sitelist as $mcsl):?>
            <li class="siteaction <?php if($mcsl->status=='1') echo 'bg-yellow'; elseif($mcsl->status=='2') echo 'bg-blue'; elseif($mcsl->status=='3') echo 'bg-green';?>" istemp="1" status=<?php echo $mcsl->status;?> sid=<?php echo $mcsl->site_id;?> shname="<?php echo $mcsl->site_id%1000;?>"><span style="font-size: 25px;"><?php echo $mcsl->site_id%1000;?>&nbsp;</span><br><?php echo $mcsl->create_at;?></li>        
        <?php endforeach;?>
        <div class="client_line"></div>
    <?php endforeach;?>
    

<script type="text/javascript">
	      
        
       
</script>