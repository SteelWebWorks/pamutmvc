<?php
use App\Models\Project;

/**
 * @var $project Project
 */
?>
<h1><?php echo $project->getTitle(); ?></h1>
<h3><?php echo $project->getStatus()->getName(); ?></h3>
<div>
    <?php echo $project->getDescription(); ?>
</div>
<div>
    <a href="mailto:<?php echo $project->getOwner()->getEmail()?>"><?php echo $project->getOwner()->getName(); ?></a>
</div>