
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebProgramming - Homework 2 <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@500&family=Kanit&family=Righteous&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>" />
    <script src="<?php echo e(asset('js/header.js')); ?>" defer></script>
    <?php echo $__env->yieldContent('script'); ?>
    
    <script type="text/javascript">
        const CSFR_TOKEN = '<?php echo e(csrf_token()); ?>';
    </script>
</head>

    <body>
        <article>
            <header>
                <nav>
                    <div id="menu">
                        <a class="menu-item" href="<?php echo e(route('index')); ?>">Home</a>
                        <a class="menu-item" id="btnLogin">Login</a>
                    </div>
                    <div id="loginWindow"
                    <?php if( !isset($error) ): ?> 
                        class="hidden"
                    <?php endif; ?>>
                        <div id="divFormLogin"
                        <?php if( $logged ): ?>
                            class="hidden"
                        <?php endif; ?>>
                            <form name="formLogin" method="post" action="<?php echo e(route ('login')); ?>">
                                <?php echo csrf_field(); ?>
                                <label>Nome Utente: <input type="text" name="username"></label>
                                <label>Password: <input type="password" name="password"></label>
                                <label>
                                    <?php if( isset($error) ): ?> 
                                        <span>Dati Errati</span>
                                    <?php endif; ?>
                                    <input id="btnSignin" type="submit" value="Accedi">
                                </label>
                            </form>
                            <div class="signup">Non hai un account? <a href="<?php echo e(route('account')); ?>">Iscriviti</a></div>
                        </div>
                        <div id="divLogged" 
                        <?php if( $logged ): ?>
                            data-user-id="<?php echo e($user->id); ?>" 
                        <?php else: ?>
                            class="hidden"
                        <?php endif; ?>>
                            <div>
                                <span>Benvenuto <?php if( $logged ): ?> <?php echo e($user->username); ?><?php endif; ?>!</span>
                                <a href="<?php echo e(route('account')); ?>">Profilo</a>
                                <?php if( $logged ): ?>
                                    
                                    <?php $UserController = app('App\Http\Controllers\UserController'); ?>
                                    <?php if( $UserController->checkAdminPermission($user->id)=='1' ): ?>
                                        <a href="<?php echo e(route('administration')); ?>">Amministrazione</a>
                                    <?php endif; ?>
                                    <?php if( $UserController->checkJobPermissions($user->id)=='1' ): ?>
                                        <a href="<?php echo e(route('job')); ?>">Nuovo Job</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <a href="<?php echo e(route('logout')); ?>">LogOut</a>
                            </div>
                        </div>
                    </div>
                </nav>
                <div id="title">
                    <h1>BitControl: Gestione lavori</h1>
                </div>
            </header>
            
            
            <section id="content">
                <?php echo $__env->yieldContent('content'); ?>
            </section>

            <footer>
                <span>
                    Powered By <em>Giuseppe Triolo Puleio - Matr. 100/0041524</em><br />
                    Corso di WebProgramming - Ingegneria Informatica 2021/2022<br />
                    Università di Catania
                </span>
            </footer>
        </article>
    </body>
</html><?php /**PATH C:\xampp\htdocs\hw2\resources\views/layouts/base.blade.php ENDPATH**/ ?>