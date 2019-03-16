<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Task Manager</h1>
      <p class="lead">Backend interface</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Users</h2>

                <p>Backend user interface</p>

                <p><a class="btn btn-default" href="/user">Users &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Projects</h2>

                <p>Backend project interface</p>

                <p><a class="btn btn-default" href="/project">Projects &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Tasks</h2>

                <p>Backend task interface</p>

                <p><a class="btn btn-default" href="/task">Tasks &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
