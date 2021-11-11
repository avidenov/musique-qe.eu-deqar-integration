<?php
$report = null;
if ( ! empty(get_query_var('report_id'))) {
    $reportId = intval(get_query_var('report_id'));
    $deqarRestClient = new \Musique\DeqarRestClient();
    $deqarService = new \Musique\DeqarService($deqarRestClient);
    $report = $deqarService->getReportById($reportId);
}

?>
<?php if ($report): ?>
    <div class="single-report">
        <?php if (count($report['programmes'])): ?>
            <h2>
                <?php foreach ($report['programmes'] as $programme): ?>
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
            </h2>
        <?php endif; ?>

        <div class="report-intro">
            <div class="report-agency">
                <?php echo $report['agency_acronym']; ?>
                <?php if ($report['agency_esg_activity']): ?>
                    <span class="activity">
                    <?php echo $report['agency_esg_activity']; ?>
                </span>
                <?php endif; ?>
            </div>

            <?php if (count($report['programmes'])): ?>
                <div class="report-programs">
                    <?php foreach ($report['programmes'] as $programme): ?>
                        <dl>
                            <dt>Programme</dt>
                            <dd><?php echo $programme['name_primary']; ?></dd>
                            <dt>Qualification</dt>
                            <dd>
                                <?php if ($programme['qualification']): ?>
                                    <?php echo $programme['qualification']; ?>
                                <?php endif; ?>
                            </dd>
                            <dt>Level</dt>
                            <dd>
                                <?php
                                if ($programme['qf_ehea_level']) {
                                    echo $programme['qf_ehea_level'];
                                }

                                if ($programme['nqf_level']) {
                                    echo $programme['nqf_level'];
                                }
                                ?>
                            </dd>
                        </dl>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="report-information">
            <dl>
                <dt>DEQAR Report ID</dt>
                <dd><?php echo $report['id']; ?></dd>
                <dt>Agency</dt>
                <dd><?php echo $report['agency_name']; ?> (<?php echo $report['agency_acronym']; ?>)</dd>
                <dt>Type</dt>
                <dd><?php echo $report['name']; ?></dd>
                <dt>Status</dt>
                <dd><?php echo $report['status']; ?></dd>
                <dt>Formal decision</dt>
                <dd><?php echo $report['decision']; ?></dd>
                <dt>Date</dt>
                <dd><?php echo date('d M, Y', strtotime($report['valid_from'])); ?></dd>
                <dt>Valid until</dt>
                <dd><?php echo date('d M, Y', strtotime($report['valid_to'])); ?></dd>
                <dt>Report and decision</dt>
                <dd><?php echo $report['id']; ?></dd>
            </dl>
        </div>

        <?php if (array_key_exists('report_files', $report) && ! empty($report['report_files'])): ?>
            <h3>Report files</h3>
            <?php foreach ($report['report_files'] as $file): ?>
                <div class="downloadable-file">
                    <div class="file-name">
                        <a href="<?php echo $file['file']; ?>" target="_blank" rel="nofollow">
                            <?php echo $file['file_display_name']; ?>
                        </a>
                    </div>
                    <div class="file-button">
                        <a href="<?php echo $file['file']; ?>" target="_blank" rel="nofollow">Download</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
<?php else: ?>
    <div class="single-report">
        <h3>Oops! The report is not found.</h3>
    </div>
<?php endif; ?>
