<?php $__env->startSection('title', '| Profilo'); ?>

<?php $__env->startSection('script'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/form.css')); ?>" />
    <script src="<?php echo e(asset('js/form.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
                
    <?php if(isset($error)>0): ?>{
        Sono presenti errori: <br/>
        <?php echo e($n=0); ?>

        <?php $__currentLoopData = $error; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($n++); ?>;
            nr. <?php echo e($n); ?>: <?php echo e($msg); ?> <br/>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    }
    <?php endif; ?>
    <?php if($logged): ?>
        <h1>Modifica Profilo</h1>
        <h3>Qui puoi modificare il tuo profilo. Devi inserire la password corretta nella conferma</h3>
    <?php else: ?>
        <h1>Modulo di registrazione al sito</h1>
        <h3>Registrati per avere la possibilità di interagire con i lavori presenti sul sito. Un amministratore valuterà se il tuo profilo ha necessità di permessi aggiuntivi.</h3>
    <?php endif; ?>
    
    <form name="formSignup" method='post' enctype="multipart/form-data" autocomplete="off" action= <?php echo e(route('signup')); ?>>
        <?php echo csrf_field(); ?>
        <div id="divFormSignup">
            <div class="new_username">
            <label>Username: <input type="text" name="new_username" <?php if($logged): ?>{ value="<?php echo e($user->username); ?>" readonly="readonly"}<?php endif; ?>></label>
            <span class="hidden">Nome utente non valido o già usato.</span>
            </div>
            <div class="new_password">
            <label>Password: <input type="password" name="new_password" <?php if($logged): ?>{ value="<?php echo e($user->password); ?>" readonly="readonly"}<?php endif; ?>></label>
            <span class="hidden">Password tra 5 e 10 caratteri.</span>
            </div>
            <div class="checkPassword">
            <label>Conferma Password: <input type="password" name="checkPassword"></label>
            <span class="hidden">Le Password non coincidono.</span>
            </div>
            <div class="name">
            <label>Nome: <input type="text" name="name" <?php if($logged): ?>{ value="<?php echo e($user->nome); ?>"}<?php endif; ?>></label>
            <span class="hidden">Nome non valido</span>
            </div>
            <div class="surname">
            <label>Cognome: <input type="text" name="surname" <?php if($logged): ?>{ value="<?php echo e($user->cognome); ?>"}<?php endif; ?>></label>
            <span class="hidden">Cognome non valido</span>
            </div>
            <div class="email">
            <label>E-mail: <input type="text" name="email" <?php if($logged): ?>{ value="<?php echo e($user->email); ?>"}<?php endif; ?>></label>
            <span class="hidden">E-mail non valida</span>
            </div>
            <input id="btnSignup" type="submit" <?php if($logged): ?>{ value="Modifica"} <?php else: ?> {value="Registrati"} <?php endif; ?> disabled>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hw2\resources\views/account.blade.php ENDPATH**/ ?>