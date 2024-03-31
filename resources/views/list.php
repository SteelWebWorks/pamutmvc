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
        $('#status').on('change', function() {
           $('#search-form').submit();
        });
    })
</script>
<form id="search-form" action="/projects/<?php echo $currentPage ?>">
    <div class="form-group mt-3 mb-2">
        <select class="form-control" name="status" id="status">
            <option value="0">Select a status for filter</option>
            <?php foreach ($statuses as $status) { ?>
                <option value="<?php echo $status->getId() ?>" <?php if ($filterStatus == $status->getId()) { echo "selected"; }?> ><?php echo $status->getName() ?></option>
            <?php } ?>
        </select>
    </div>
</form>
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
            <li class="page-item"><a class="page-link" href="/projects/<?php echo $prevPage; if($filterStatus){ echo "?status=" . $filterStatus; } ?>">Previous</a></li>
            <?php for($i=1; $i<=$totalPageCount; $i++) { ?>
                <li class="page-item"><a class="page-link <?php if($currentPage == $i) { echo 'active'; } ?>" href="/projects/<?php echo $i; if($filterStatus){ echo "?status=" . $filterStatus; } ?>"><?php echo $i ?></a></li>
            <?php } ?>
            <li class="page-item"><a class="page-link" href="/projects/<?php echo $nextPage; if($filterStatus){ echo "?status=" . $filterStatus; } ?>">Next</a></li>
            <?php if ($currentPage < $totalPageCount) { ?>
                <li class="page-item"><a class="page-link" href="/projects/<?php echo $totalPageCount; if($filterStatus){ echo "?status=" . $filterStatus; } ?>">Last</a></li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>
</div>