共有 <?php echo $recordCount?> 条记录,
每页显示 <?php echo $pageSize?> 条,
当前 <?php echo $pageCount==0?0:$pageNum?>/<?php echo $pageCount?> 页:
<?php 
if($panelCur==1)
{
	if($pageCount<$pageShowRange)
	{
		$loopCount = $pageCount-1;
	}
	else
	{
		$loopCount = $pageShowRange-1;
	}
	
	$pageOfPanelCur = 2;
	$nextBtnPage = $pageShowRange+1;	
}
else if($panelCur==$panelTotal)
{
	$m = $pageCount%$pageShowRange;
	$loopCount = $m==0?$pageShowRange:$pageCount%$pageShowRange;
	$pageOfPanelCur = $pageCount-$loopCount;
	$preBtnPage = $pageOfPanelCur-1;
}
else
{
	$loopCount = $pageShowRange;
	$loopCount = $pageCount>$loopCount?$loopCount:$pageCount;
	$pageOfPanelCur = ($panelCur-1)*$pageShowRange+1;
	
	$preBtnPage = $pageOfPanelCur-1;
	$nextBtnPage = $loopCount+$pageOfPanelCur;
}
?>
<?php if($pageCount>0){ ?>
<span class="multi_page">
<a class="page_btn<?php echo ($pageNum==1?' cur':'')?>" href="?page=1">1</a>
	<?php if($panelCur>1){ ?>
<a class="page_btn<?php echo ($pageNum==$preBtnPage?' cur':'')?>" href="?page=<?php echo $preBtnPage?>">&lt;&lt;</a>
	<?php } ?>
	<?php
	for($i=0;$i<$loopCount;$i++){ 
	?>
<a class="page_btn<?php echo ($pageNum==($pageOfPanelCur+$i)?' cur':'')?>" href="?page=<?php echo $pageOfPanelCur+$i?>"><?php echo $pageOfPanelCur+$i?></a>
	<?php 
	} 
	?>

	<?php if($panelCur<$panelTotal && $pageCount>$panelCur*$pageShowRange+1){ ?>
<a class="page_btn<?php echo ($pageNum==$nextBtnPage?' cur':'')?>" href="?page=<?php echo $nextBtnPage?>">&gt;&gt;</a>
	<?php } ?>

	<?php if($pageCount>$pageShowRange){ ?>
<a class="page_btn<?php echo ($pageNum==$pageCount?' cur':'')?>" href="?page=<?php echo $pageCount?>"><?php echo $pageCount?></a>
	<?php } ?>
</span>
<?php } ?>
