<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'users','method'=>'post'))); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('name',__('Name'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))); ?>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('email',__('Email'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))); ?>

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="invalid-email" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <?php if(\Auth::user()->type != 'super admin'): ?>
            <div class="form-group col-md-6">
                <?php echo e(Form::label('role', __('User Role'),['class'=>'form-control-label'])); ?>

                <?php echo Form::select('role', $roles, null,array('class' => 'form-control select2','required'=>'required')); ?>

                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="invalid-role" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        <?php elseif(\Auth::user()->type == 'super admin'): ?>
        <?php echo Form::hidden('role', 'company', null,array('class' => 'form-control select2','required'=>'required')); ?>

        <?php endif; ?>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('password',__('Password'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter User Password'),'required'=>'required','minlength'=>"6"))); ?>

                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="invalid-password" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <?php if(!$customFields->isEmpty()): ?>
            <div class="col-md-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    <?php echo $__env->make('customFields.formBuilder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-12 pt-5 text-right">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH R:\Projects\new\test_ola\resources\views/user/create.blade.php ENDPATH**/ ?>