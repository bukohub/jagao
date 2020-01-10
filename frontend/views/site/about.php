<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Acerca Jagao';
$this->params['breadcrumbs'][] = $this->title;
?>
 <main id="about-us">
                <div class="container inner-top-xs inner-bottom-sm">
                    <div class="row">
                        <div class="col-xs-12">
                            
                            <section id="who-we-are" class="section m-t-0">
                                <h2>Acerca de nosotros</h2>
                                <?php foreach($acerca as $acerca ): ?>
                                    <p><?= $acerca->descripcion; ?></p>
                                <?php endforeach; ?>
                            </section><!-- /#who-we-are -->
                        </div><!-- /.col -->
                        
                    </div><!-- /.row -->
                </div><!-- /.container -->

            </main><!-- /#about-us -->
