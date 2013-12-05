<div class="panel">
<?php
if ($this->is_markdown) {
	echo \Michelf\MarkdownExtra::defaultTransform($this->contents);
} else {
	echo '<pre>'.$this->contents.'</pre>';
} ?>
</div>
