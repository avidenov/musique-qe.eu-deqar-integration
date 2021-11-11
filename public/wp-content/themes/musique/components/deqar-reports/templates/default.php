<?php

global $post;

$deqarRestClient = new \Musique\DeqarRestClient();
$deqarService = new \Musique\DeqarService($deqarRestClient);

$pageNumber = 0;
if ( ! empty(get_query_var('paged'))) {
    $pageNumber = intval(get_query_var('paged'));
}

$reports = $deqarService->getReportsByAgency($pageNumber * 10);

$totalPages = floor($reports['count'] / 10);

$nextPage = $pageNumber + 1;
$previousPage = $pageNumber - 1;

if ($nextPage >= $totalPages) {
    $nextPage = $totalPages;
}

if ($nextPage == 1) {
    $nextPage = 2;
}

if ($previousPage <= 1) {
    $previousPage = 1;
}
?>

<div class="deqar-reports">
    <?php foreach ($reports['results'] as $report): ?>
        <?php DeqarReportPreview::render(['data' => $report]); ?>
    <?php endforeach; ?>

    <div class="reports-pagination">
        <ul>
            <li <?php if ($pageNumber <= 1): ?> class="disabled" <?php endif; ?> >
                <?php if ($previousPage <= 1): ?>
                    <a href="<?php echo get_permalink($post->ID); ?>">Previous page</a>
                <?php else: ?>
                    <a href="<?php echo get_permalink($post->ID); ?>page/<?php echo $previousPage; ?>">Previous page</a>
                <?php endif; ?>
            </li>
            <li <?php if ($pageNumber >= $totalPages): ?> class="disabled" <?php endif; ?>>
                <a href="<?php echo get_permalink($post->ID); ?>page/<?php echo $nextPage; ?>">Next page</a>
            </li>
        </ul>
    </div>
</div>
