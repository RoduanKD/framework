<?php

namespace Illuminate\Tests\View\Blade;

class BladeErrorTest extends AbstractBladeTestCase
{
    public function testErrorsAreCompiled()
    {
        $string = '
@error(\'email\')
    <span>{{ $message }}</span>
@enderror';
        $expected = '
<?php $__errorArgs = [\'email\'];
$__bag = $errors->getBag($__errorArgs[1] ?? \'default\');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <span><?php echo e($message); ?></span>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>';

        $this->assertEquals($expected, $this->compiler->compileString($string));
    }

    public function testErrorsWithBagsAreCompiled()
    {
        $string = '
@error(\'email\', \'customBag\')
    <span>{{ $message }}</span>
@enderror';
        $expected = '
<?php $__errorArgs = [\'email\', \'customBag\'];
$__bag = $errors->getBag($__errorArgs[1] ?? \'default\');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <span><?php echo e($message); ?></span>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }

    public function testErrorClassesAreComplied()
    {
        $string = '@errorclass(\'email\', \'is-danger\')';

        $expected = '
<?php $__errorArgs = [\'email\',\'default\'];
$__bag = $errors->getBag($__errorArgs[1]);
if ($__bag->has($__errorArgs[0])){ echo \'is-danger\';}
unset($__errorArgs, $__bag);?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }

    public function testErrorClasseswithBagsAreComplied()
    {
        $string = '@errorclass(\'email\', \'is-danger\', \'custom-bag\')';

        $expected = '
<?php $__errorArgs = [\'email\',\'custom-bag\'];
$__bag = $errors->getBag($__errorArgs[1]);
if ($__bag->has($__errorArgs[0])){ echo \'is-danger\';}
unset($__errorArgs, $__bag);?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }
}
