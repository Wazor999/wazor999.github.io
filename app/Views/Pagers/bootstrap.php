<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
<ul class="pagination justify-content-center">

<?php if ($pager->hasPrevious()) : ?>
    <li class="page-item">
        <a class="page-link" href="<?= $pager->getFirst() ?>">
            <i class="bi bi-chevron-double-left"></i>
        </a>
    </li>
    <li class="page-item">
        <a class="page-link" href="<?= $pager->getPrevious() ?>">
            <i class="bi bi-chevron-left"></i>
        </a>
    </li>
<?php endif ?>

<?php foreach ($pager->links() as $link) : ?>
    <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>">
            <?= $link['title'] ?>
        </a>
    </li>
<?php endforeach ?>

<?php if ($pager->hasNext()) : ?>
    <li class="page-item">
        <a class="page-link" href="<?= $pager->getNext() ?>">
            <i class="bi bi-chevron-right"></i>
        </a>
    </li>
    <li class="page-item">
        <a class="page-link" href="<?= $pager->getLast() ?>">
            <i class="bi bi-chevron-double-right"></i>
        </a>
    </li>
<?php endif ?>

</ul>
</nav>