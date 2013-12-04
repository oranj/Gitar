<div class="panel">
<?php
if ($this->is_markdown) {
	echo \Michelf\Markdown::defaultTransform($this->contents);
} else {
	echo '<pre>'.$this->contents.'</pre>';
} ?>
</div>
