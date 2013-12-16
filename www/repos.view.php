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
				<option value="date" selected="selected">Sort By Last Modified</option>
			</select>
		</li>
		<li>
			<input type="text" id="filter" data-smartdefault="Filter..." />
		</li>
	</ul>
	<div class="clearing"></div>
</div>
<div class="repos sortcontainer">
<?php foreach ($repos as $repo_name => $repo) {
	$log = $repo['log'];
	?>

	<div class="sortable repo panel"
		data-search="<?= strtolower($repo_name) ?>"
		data-date="<?= $log['timestamp'] ?>"
		data-title="<?= strtolower($repo['title']) ?>">

		<div class="panel_date"><label>Last updated </label><?= mydate($log['timestamp']) ?></div>
		<div class="panel_title">
			<a href="/<?= $repo['repo'] ?>/:auto">
				<?= $repo['title'] ?>
			</a>
		</div>
		<div class="repo_url"><?= $repo['url'] ?></div>
		<?php if ($log['author_gravatar']) { ?>
		<div class="panel_image">
			<img src="http://www.gravatar.com/avatar/<?= $log['author_gravatar'] ?>?s=60&amp;d=identicon&amp;r=pg" />
		</div>
		<?php } ?>
		<div class="panel_author">
			<?= $log['author_name'] ?>
		</div>
		<div class="panel_content">
			<?= nl2br(htmlentities(join("\n", $log['message']))) ?>
		</div>
		<?php if (isset($log['commit'])) { ?>
		<div class="panel_note">
			<a href="/<?= $repo['repo']?>/$<?= $log['commit'] ?>/"><?= $log['commit'] ?></a>
		</div>
		<?php } ?>
		<div class="clearing"></div>
	</div>

<?php } ?>
</div>
