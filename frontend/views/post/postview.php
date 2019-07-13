<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'post';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">

        <a href=<?php echo Url::to(['post/create']); ?>>
            <div style="margin-bottom:2%;padding: 2%">
                <button type="submit" id="edit" class="btn btn-primary btn-lg " style="padding: 2%">
                    + create new Post
                </button>
            </div>
        </a>


        <div class="row">

            <?php foreach ($posts as $post) {

                $min = 1;
                $max = 100;
                $rand = rand($min, $max);
                ?>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <a href=<?= 'post/view?id=' . $post['id']; ?>>
                            <img class="card-img-top" src="https://picsum.photos/id/<?= $rand ?>/200/200"
                                 alt="Card image cap">
                            <h3> <?= $post['title']; ?></h3>
                        </a>


                        <div class="card-body">
                            <p class="card-text"><?= substr($post['text'], 0, 100); ?></p>
                        </div>
                        <a href=<?= 'author?author=' . $post['author']; ?>>
                            <h5>Author: <?= $post['author']; ?></h5>
                        </a>
                        <h5>Created At: <?= $post['created_at']; ?></h5>

                    </div>
                    <div id="{{ $tvshow->id }}">

                        <a href=<?php
                        $upate = 'post/update?id=' . $post['id']; ?>
                            <?= Url::to([$upate]); ?>>
                            <button type="submit" id="edit" class="btn btn-primary">
                                Edit
                            </button>
                        </a>

                        <?= Html::a('Delete', ['delete', 'id' => $post['id']], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            <?php } ?>
        </div>
    </div>

</div>
