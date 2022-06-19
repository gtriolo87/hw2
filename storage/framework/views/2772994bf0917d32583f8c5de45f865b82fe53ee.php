<?php $__env->startSection('title', '| Amministrazione profili'); ?>

<?php $__env->startSection('script'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/administration.css')); ?>" />
    <script src="<?php echo e(asset('js/administration.js')); ?>" defer></script> 
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<h1> Gestione Utenti </h1>
<div id="divRicerca">
    <form name="formSearch" id="formSearch">
        <select name="searchProfile">
            <option value="0">Tutti</option>
            <option value="1">Visitatore</option>
            <option value="2">Amministratore</option>
            <option value="3">Manager</option>
            <option value="4">Operatore</option>
        </select>
        <input type="submit" value="Ricerca">
    </form>
    <span>Puoi ricercare solo gli utenti di un particolare profilo.</span>
</div>

<table>
    <thead>
        <tr>
            <th class="colUserId">ID</th>
            <th class="colUsername">Nome Utente</th>
            <th class="colName">Nome</th>
            <th class="colSurname">Cognome</th>
            <th class="colEmail">E-mail</th>
            <th class="colProfile">Profilo</th>
            <th class="colEdit">Salva Modifiche</th>
        </tr>
    </thead>
    
    <!-- il tbody veniva riempito dal js con chiamate asincrone al db
    In Laravel lo riempiro in maniera sincrona poichè la vista verrà richiamata con la lista utenti -->
    <tbody>
        <?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="colUserId"><?php echo e($row->id); ?></td>
            <td class="colUsername"><?php echo e($row->username); ?></td>
            <td class="colName"><?php echo e($row->nome); ?></td>
            <td class="colSurname"><?php echo e($row->cognome); ?></td>
            <td class="colEmail"><?php echo e($row->email); ?></td>
            <td class="colProfile">
                <select name="searchProfile" data-user_id="<?php echo e($row->id); ?>">
                    <option value="1" <?php if($row->group_id===1): ?> selected="selected" <?php endif; ?>>Visitatore</option>
                    <option value="2" <?php if($row->group_id===2): ?> selected="selected" <?php endif; ?>>Amministratore</option>
                    <option value="3" <?php if($row->group_id===3): ?> selected="selected" <?php endif; ?>>Manager</option>
                    <option value="4" <?php if($row->group_id===4): ?> selected="selected" <?php endif; ?>>Operatore</option>
                </select>
            </td>
            <td class="colEdit"><a href="@" data-user_id="<?php echo e($row->id); ?>">Aggiorna</a></td>
        </tr>            
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>

    <tfoot>
        <tr>
            <td class="colUserId">ID</td>
            <td class="colUsername">Nome Utente</td>
            <td class="colName">Nome</td>
            <td class="colSurname">Cognome</td>
            <td class="colEmail">E-mail</td>
            <td class="colProfile">Profilo</td>
            <td class="colEdit">Salva Modifiche</td>
        </tr>
    </tfoot>
</table>
<span id="esitoModifica" class="hidden"></span>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hw2\resources\views/administration.blade.php ENDPATH**/ ?>