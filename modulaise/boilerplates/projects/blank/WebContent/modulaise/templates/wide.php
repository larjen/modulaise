<?php include '_head.php';?>
<?php ModulaiseController::printPane("head"); ?>
<?php ModulaiseController::printPane("main"); ?>
<br clear="all" />
<hr />
<h2>Footer</h2>
<?php ModulaiseController::printPane("foot"); ?>
<?php  if (ModulaiseController::paneHasContent("extra")){ ?>
<br clear="all" />
<div class="pane-extra">
<h2>Extra</h2>
<?php ModulaiseController::printPane("extra"); ?>
</div>
<?php } ?>
<?php include '_foot.php';?>