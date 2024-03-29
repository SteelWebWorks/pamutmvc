<div id="project-list">
<?php
use App\Models\Project;
/**
 * @var Project[]|array|object[] $projects
 * @var int $totalPageCount
 */
foreach ($projects as $project) { ?>
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
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <?php for($i=1; $i<=$totalPageCount; $i++) { ?>
            <li class="page-item"><a class="page-link" href="#"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</div>
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