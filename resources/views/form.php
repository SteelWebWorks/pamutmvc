<?php use Doctrine\Common\Collections\Collection; ?>
<script type="application/javascript">
    $(function () {
        var existingOwner = $('div#existing-owner'),
            newOwner = $('div#new-owner'),
            contactCheckbox = $('#contact-checkbox');

        var contactDisplay = function () {
            if (contactCheckbox.is(':checked')) {
                existingOwner.hide();
                newOwner.show()
            } else {
                existingOwner.show();
                newOwner.hide();
            }
        }

        contactDisplay();

        contactCheckbox.on('click', function (e) {
            contactDisplay();
        })

        $('form#projectForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).find(":input:not(:hidden)").serialize();
            $.post('/new', formData, function (response) {
                var data = JSON.parse(response)
                $('div#create-form').html(data.view);
            })

        })
    })
</script>
<div id="create-form">
    <form id="projectForm" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Projekt neve</label>
            <?php if (isset($errors) && isset($errors['title'])) { ?>
                <span class="text-danger">
                    <?php echo $errors['title'][0] ?>
                </span>
            <?php } ?>
            <input type="text" class="form-control" id="title" name="title" value="<?php if (isset($project)) {
                echo $project->getTitle();
            } ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Projekt leírása</label>
            <?php if (isset($errors) && isset($errors['description'])) { ?>
                <span class="text-danger">
                    <?php echo $errors['description'][0] ?>
                </span>
            <?php } ?>
            <textarea name="description" id="description" cols="30" rows="10"
                      class="form-control"><?php if (isset($project)) {
                    echo $project->getDescription();
                } ?></textarea>

        </div>
        <div class="mb-3">
            <label class="form-label" for="status">Állapot</label>
            <select class="form-select" aria-label="" id="status" name="status">
                <?php /** @var Collection $statuses */
                foreach ($statuses as $status) { ?>
                    <option <?php if (isset($project) && $project->getStatusId() == $status->getId()) { ?> selected <?php } ?>
                            value="<?php echo $status->getId() ?>"><?php echo $status->getName() ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <div class="form-group">
                <div class="form-check">
                    <input <?php if (isset($old) && isset($old['contact-checkbox'])) {
                        echo 'checked';
                    } ?> class="form-check-input" type="checkbox" value="" id="contact-checkbox"
                         name="contact-checkbox">
                    <label class="form-check-label" for="contact-checkbox">Új kapcsolattartó</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-group">
                <div id="existing-owner">
                    <label class="form-label" for="owner">Kapcsolattartó</label>
                    <select class="form-select" aria-label="" id="owner" name="owner">
                        <?php /** @var Collection $owners */
                        foreach ($owners as $owner) { ?>
                            <option value="<?php echo $owner->getId() ?>"><?php echo $owner->getName() ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div id="new-owner" style="display:none;">
                    <label class="form-label" for="owner-name">Kapcsolattartó neve</label>
                    <?php if (isset($errors) && isset($errors['owner-name'])) { ?>
                        <span class="text-danger">
                            <?php echo $errors['owner-name'][0] ?>
                        </span>
                    <?php } ?>
                    <input class="form-control" type="text" id="owner-name" name="owner-name">
                    <label class="form-label" for="owner-email">Kapcsolattartó email címe</label>
                    <?php if (isset($errors) && isset($errors['email'])) { ?>
                        <span class="text-danger">
                            <?php echo $errors['owner-email'][0] ?>
                        </span>
                    <?php } ?>
                    <input class="form-control" type="text" id="owner-email" name="owner-email">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Mentés</button>
    </form>
</div>
