<style>
    h2,h3,form {
        display: flex;
        flex-direction: column;
    }

    button {
        margin-top: 15px;
    }

    label {
        display: flex;
        flex-direction: column;
    }
</style>

<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="post">
<input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Имя <input type="text" name="name"></label>
    <label>Логин <input type="text" name="login"></label>
    <label>Пароль <input type="password" name="password"></label>
    <label>Роль 
        <select name="role">
            <option value="administrator">Администратор</option>
            <option value="dekan">Декан</option>
        </select>
    </label>
    <button>Зарегистрироваться</button>
</form>
