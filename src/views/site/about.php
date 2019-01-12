<?php

/**
 * about is the view Web Application Basic.
 **/

use yii\helpers\Html;

$this->title = $this->getApp()->t('basic', 'About');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::beginTag('div', ['class' => 'site-about"']) ?>

	<?= Html::tag('h1', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'c-grey-900 mb-40']) ?>
	<?= Html::tag('p', $this->getApp()->t('basic', 'This is the About page. You may modify the following file to customize ' .
		'its content.')) ?>

	<code><?= __FILE__ ?></code>

<?= Html::endTag('div') ?>