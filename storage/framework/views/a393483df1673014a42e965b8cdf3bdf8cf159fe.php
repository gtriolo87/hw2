<?php $__env->startSection('title', '| Gestione Lavori'); ?>

<?php $__env->startSection('script'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/job.css')); ?>" />
    <script src="<?php echo e(asset('js/job.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="divEditJob">
    <?php if(is_null($jobData)): ?>
        <h1>Modulo di Inserimento nuovo Lavoro</h1>
    <?php else: ?> 
        <h1>Modifica Lavoro</h1>
    <?php endif; ?>
    <form name="formAddJob" enctype="multipart/form-data" autocomplete="off">
        <?php echo csrf_field(); ?>
        <div class="jobTitle">
            <label>Titolo: <input type="text" name="jobTitle" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->title); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Titolo non valido.</span>
        </div>
        <div class="jobCustomer">
            <label>Cliente: <input type="text" name="jobCustomer" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->customer); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Cliente non valido.</span>
        </div>
        <div class="jobDevice">
            <label>Dispositivo/SCADA: <input type="text" name="jobDevice" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->device); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Dispositivo non valido.</span>
        </div>
        <div class="jobEndingYear">
            <label>Anno fine Lavoro: <input type="text" name="jobEndingYear" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->endingYear); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Anno non valido.</span>
        </div>
        <div class="jobDescription">
            <label>Descrizione: <input type="textbox" name="jobDescription" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->description); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Descrizione non valida.</span>
        </div>
        <div class="jobLat">
            <label>Latitudine: <input type="text" name="jobLat" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->latitude); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Latitudine non valida.</span>
        </div>
        <div class="jobLong">
            <label>Longitudine: <input type="text" name="jobLong" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->longitude); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Longitudine non valida.</span>
        </div>
        <div class="jobKeywords">
            <label>Parole Chiave: <input type="text" name="jobKeywords" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->keywords); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Parole chiave non valide.</span>
        </div>
        <div class="jobImage">
            <label>Scegli un'immagine: <input type="text" name="jobImage" <?php if(!is_null($jobData)): ?> value="<?php echo e($jobData->image); ?>" <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden">Inserisci un url corretto.</span>
        </div>
        <div class="jobHasVideo">
            <label>Presenza Video su YouTube? <input type="checkbox" name="jobHasVideo" <?php if(!is_null($jobData) && $jobData->hasVideo): ?> checked  <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden"> </span>
        </div>
        <div class="jobEnded">
            <label>Lavoro Finito? <input type="checkbox" name="jobEnded" <?php if(!is_null($jobData) && $jobData->jobEnded): ?> checked  <?php endif; ?> <?php if(!$canManageJob): ?> disabled  <?php endif; ?>></label>
            <span class="hidden"> </span>
        </div>
        <div class="jobSubmit">
            <input id="btnSubmit" type="submit" 
            <?php if(is_null($jobData)): ?>
                value="Inserisci"
            <?php else: ?> 
                value="Modifica" data-job_id="<?php echo e($jobData->id); ?>"
            <?php endif; ?>
            disabled>
        <strong  <?php if(!$jobError): ?>  class="hidden"  <?php endif; ?>>Esito: </strong>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hw2\resources\views/job.blade.php ENDPATH**/ ?>