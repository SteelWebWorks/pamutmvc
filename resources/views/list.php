<?php
use App\Models\Project;
/**
 * @var Project[]|array|object[] $projects
 * @var int $totalPageCount
 */ ?>
 
<script type="application/javascript">
    $(function() {
        $('a[data-project-id]').on('click', function(e){
            e.preventDefault();
            $.get("/project/" + $(this).data('project-id') + "/delete", function(response) {
                $('div#project-list').html(response);
            })
        })
    })
</script>

<div id="project-list">
<?php foreach ($projects as $project) { ?>
    <div class="card mb-2">
        <div class="card-title p-3">
            <div class="d-flex justify-content-between">
                <h5><?php echo $project->getTitle() ?></h5><span class=""><?php echo $project->getStatus()->getName() ?></span>
            </div>
            <span class=""><?php echo $project->getOwner()->getName() . ' (' . $project->getOwner()->getEmail() . ')' ?></span>
        </div>
        <div class="card-body">
            <a href="/project/<?php echo $project->getId() ?>/edit" class="btn btn-primary">Szerkesztés</a>
            <a data-project-id="<?php echo $project->getId() ?>" href="" class="btn btn-danger">Törlés</a>
        </div>
    </div>
<?php } ?>

<?php if (!empty($projects)) { ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($currentPage > 1) { ?>
                <li class="page-item"><a class="page-link" href="/projects/1">First</a></li>
            <?php } ?>
            <li class="page-item"><a class="page-link" href="/projects/<?php echo $prevPage; ?>">Previous</a></li>
            <?php for($i=1; $i<=$totalPageCount; $i++) { ?>
                <li class="page-item"><a class="page-link <?php if($currentPage == $i) { echo 'active'; } ?>" href="/projects/<?php echo $i; ?>"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="page-item"><a class="page-link" href="/projects/<?php echo $nextPage; ?>">Next</a></li>
            <?php if ($currentPage < $totalPageCount) { ?>
                <li class="page-item"><a class="page-link" href="/projects/<?php echo $totalPageCount; ?>">Last</a></li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>
</div>