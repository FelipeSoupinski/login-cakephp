<?php $this->layout = 'login'; ?>

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <div class="login-logo">
                <?= $this->Html->image('user.svg') ?>
            </div>
            <?= $this->Flash->render() ?>
            <?= $this->Form->create($user) ?>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Enviar email</button>
            </form>
            <p class="mb-1 mt-1"><?= $this->Html->link('Entrar', ['action' => 'login']) ?></p>
            <p class="mb-1 mt-2"><?= $this->Html->link('Registrar-se', ['action' => 'register']) ?></p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->