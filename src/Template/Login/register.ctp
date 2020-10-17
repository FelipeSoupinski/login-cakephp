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
                    <input type="text" name="nome" class="form-control" placeholder="Nome" maxlength="255" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" maxlength="255" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Senha" maxlength="255" minlength="8" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
            </form>
            <p class="mb-1 mt-2"><?= $this->Html->link('Já possui uma conta?', ['action' => 'login']) ?></p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->