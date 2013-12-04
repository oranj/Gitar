<?php

namespace Roto;

$title = makeTitle();
$this->region('title', $title);

include_once('lib/git.php');

$repos = getRepoInformation(
	Service::CFG()->repo['root'],
	Service::CFG()->repo['web_root']
);

?>
<div class="repos">
<?php foreach ($repos as $repo_name => $repo) { ?>
	<div class="repo panel"
		data-search="<?= strtolower($repo_name) ?>"
		data-date="<?= $repo['date'] ?>"
		data-title="<?= $repo['title'] ?>">

		<div class="last_commit"><?= mydate($repo['date'])?></div>
		<div class="panel_title">
			<a href="/repos/<?= $repo['repo'] ?>/">
				<?= $repo_name ?>
			</a>
		</div>

		<div class="repo_url"><?= $repo['url'] ?></div>
		<div class="commit"><?= nl2br($repo['log']) ?></div>
	</div>

<?php } ?>
</div>
