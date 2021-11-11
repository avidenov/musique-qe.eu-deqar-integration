<?php
$report = $templateArgs->data;

?>
<div class="report-preview">
    <div class="report-dates">
        <?php if ($report->valid_from): ?>
            <div class="report-date">
                <span>Report date</span>
                <?php echo date('d M, Y', strtotime($report->valid_from)); ?>
            </div>
        <?php endif; ?>

        <?php if ($report->valid_to): ?>
            <div class="report-date">
                <span>Valid to</span>
                <?php echo date('d M, Y', strtotime($report->valid_to)); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="report-agency">
        <?php if (count($report->country)): ?>
            <?php foreach ($report->country as $index => $country): ?>
                <?php if ($index > 0): ?>, <?php endif; ?><?php echo $country; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($report->agency_esg_activity): ?>
            <span class="activity">
            <?php echo $report->agency_esg_activity; ?>
        </span>
        <?php endif; ?>
    </div>

    <div class="report-description">
        <?php if (count($report->institutions)): ?>
            <?php foreach ($report->institutions as $institution): ?>
                <?php echo $institution['name_primary']; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (count($report->programmes)): ?>
            -
            <?php foreach ($report->programmes as $programme): ?>
                <?php echo $programme['name_primary']; ?>
                <?php
                if ($programme['qf_ehea_level']) {
                    echo ' (' . $programme['qf_ehea_level'] . ')';
                }

                if ($programme['nqf_level']) {
                    echo ' (' . $programme['nqf_level'] . ')';
                }
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a class="view-report" href="/<?php echo get_field('deqar_report_list_page', 'options'); ?>/report/<?php echo $report->id; ?>">View report</a>
</div>
