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
<div class="nav">
	<ul>
		<li>
			<select id="sortby">
				<option value="title" order="asc">Sort By Title</option>
				<option value="date">Sort By Last Modified</option>
			</select>
		</li>
		<li>
			<input type="text" id="filter" data-smartdefault="Filter..." />
		</li>
	</ul>
	<div class="clearing"></div>
</div>
<div class="repos">
<?php foreach ($repos as $repo_name => $repo) { ?>
	<div class="repo panel"
		data-search="<?= strtolower($repo_name) ?>"
		data-date="<?= $repo['date'] ?>"
		data-title="<?= strtolower($repo['title']) ?>">

		<div class="last_commit"><?= mydate($repo['log']['timestamp'])?></div>
		<div class="panel_title">
			<a href="/repos/<?= $repo['repo'] ?>/">
				<?= $repo['title'] ?>
			</a>
		</div>

		<div class="repo_url"><?= $repo['url'] ?></div>
		<div class="commit"><?= nl2br(join("\n", $repo['log']['data'])) ?></div>
	</div>

<?php } ?>
</div>
