<div class="clearfix"></div>
</div>
<div class="col-xs-4 right-panel notranslate">
<div class="box teamspeak">
<div class="head">Conta</div>
<div class="box-content">
<div class="item">
<div class="wrap">
<div class="tab-pane active">

<?php if (user_logged_in() === true): ?>
<p>Bem-vindo à página da sua conta, <strong><font color="blue"><?php if ($config['ServerEngine'] !== 'OTHIRE') echo $user_data['name']; else echo $user_data['id']; ?></font></strong><br>
            <?php if ($config['ServerEngine'] !== 'OTHIRE') {
                if ($user_data['premdays'] != 0) {
                    echo 'Você tem <font color"green">' .$user_data['premdays']. '</font> dias restantes da conta premium.';
                } else {
                    echo 'Você é uma conta gratuita.';
                }
            } else {
                if ($user_data['premend'] != 0) {
                    echo 'Sua conta premium durará até ';
                    echo date("d/m/Y", $user_data['premend']);
                } else {
                    echo 'Você não tem dias de conta premium.';
                }
            }
            if ($config['mailserver']['myaccount_verify_email']):
                ?><br>Email: <?php echo $user_data['email'];
                if ($user_znote_data['active_email'] == 1) {
                    ?> (Verified).<?php
                } else {
                    ?><br><strong>Seu E-mail não é verificado! <a href="?authenticate">Por favor verifique aqui!</a>.</strong><?php
                }
            endif; ?>
        </p>
            <div class="inner">

            <hr>
            <a href="myaccount.php" class="btn btn-primary btn-shiny btn-block">
                <font color="gold">Minha Conta</font></a>

            <a href="createcharacter.php" class="btn btn-primary btn-shiny btn-block">
                <font color="gold">Criar Personagem</font></a>

            <a href="changepassword.php" class="btn btn-primary btn-shiny btn-block">
                <font color="gold">Trocas Senha</font></a>

            <a href="settings.php" class="btn btn-primary btn-shiny btn-block">
            <font color="gold">Configurações</font></a>

            <a href="logout.php" class="btn btn-primary btn-shiny btn-block">
            <font color="gold"> Sair</font></a>

    <?php else: ?>
<form class="loginForm" method="post" action="login.php">
<div class="form-group">
    <input type="text" name="username" id="login_username" class="form-control" />
</div>
<div class="form-group">
    <input class="form-control" type="password" name="password" id="login_password" />
</div>
<?php if ($config['twoFactorAuthenticator']): ?>
                <div class="input-group">
                    <input class="form-control" type="password" name="authcode">
                </div>
            <?php endif; ?>
<div class="centered">
    <input type="submit" name="Submit" class="btn btn-blue submitButton" value="Log in" />
<a href="register.php" class=""><strong>Criar Conta</strong></a></div>
</form>
<?php endif; ?>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
<div class="box">
<div class="head">Eventos Por vir</div>
<div class="box-content">
<div id="event-container"></div>

</div>
</div>

<div class="box latest-posts">
<div class="head">Social</div>
<div class="box-content">
 <div class="centered">
<a href="DISCORD URL" target="_blank"><img width=60px src="images/discord.png"></a>&nbsp;&nbsp;<a href="TEAMSPEAK URL"><img width=50px src="layouts/img/ts.png"></a>
</div>
<br><div class="fb-page" data-href="https://www.facebook.com/tibia" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/gunzodus"><a href="https://www.facebook.com/gunzodus">Gunzodus</a></blockquote></div></div>
</div>
</div>
<div class="box">
<div class="head">stats</div>
<div class="box-content">
<div class="item">
<div class="item-head">Top Guild</div>
<div class="wrap">
<a href="topguilds.php" class="btn btn-blue">Guilds</a>
</div>
</div>
<div class="item">
<div class="item-head">Top Level</div>
<div class="wrap">
<a href="highscores.php" class="btn btn-blue">Highscores</a>
</div>
</div>
<div class="item">
<div class="item-head">Top Fragger</div>
<div class="wrap">
<a href="killers.php" class="btn btn-blue">Killers</a>
</div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="centered small"><p>© 2024, Shire Legends RPG</p><br>
</div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
</body>
<footer>

</footer>
<script>
    // Função para fazer a requisição AJAX
    function fetchEvents() {
        // Substituir o mock pela requisição real usando fetch
        fetch('api/modules/events/events.php')  // Substitua pelo caminho correto do arquivo PHP
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();  // Espera um retorno JSON do PHP
            })
            .then(data => {
                // Verifica se a resposta contém eventos
                if (data.data && data.data.events && data.data.events.length > 0) {
                    var events = data.data.events;
                    var eventContainer = document.getElementById('event-container');

                    // Limpa o contêiner de eventos antes de adicionar novos
                    eventContainer.innerHTML = '';

                    // Itera sobre os eventos e cria os itens HTML dinamicamente
                    events.forEach(function(event) {
                        var item = document.createElement('div');
                        item.classList.add('item');

                        var wrap = document.createElement('div');
                        wrap.classList.add('wrap');
                        item.appendChild(wrap);

                        var left = document.createElement('div');
                        left.classList.add('left');
                        var img = document.createElement('img');
                        img.src = 'images/events/zombie.gif';  // Ajuste para o caminho correto
                        img.alt = event.name;
                        left.appendChild(img);
                        wrap.appendChild(left);

                        var right = document.createElement('div');
                        right.classList.add('right');
                        var title = document.createElement('div');
                        title.classList.add('title');
                        title.textContent = event.name;
                        right.appendChild(title);

                        var info = document.createElement('div');
                        info.classList.add('info');

                        // Adiciona a contagem regressiva
                        var countdownElement = document.createElement('div');
                        countdownElement.classList.add('countdown');
                        info.appendChild(countdownElement);

                        // Função para calcular o tempo restante e exibir a contagem regressiva
                        function updateCountdown() {
                            var now = new Date().getTime();
                            var targetDate = new Date(event.start_date).getTime();
                            var distance = targetDate - now;

                            if (distance > 0) {
                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                countdownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                                countdownElement.style.color = '#ff6347'; // Cor original (vermelho)
                            } else {
                                countdownElement.innerHTML = "Evento Iniciado!";
                                countdownElement.style.color = 'green'; // Cor verde quando o evento começa
                            }
                        }

                        // Atualiza a contagem regressiva a cada segundo
                        setInterval(updateCountdown, 1000);
                        updateCountdown();  // Atualiza imediatamente ao carregar

                        right.appendChild(info);
                        wrap.appendChild(right);

                        // Adiciona o item ao contêiner de eventos
                        eventContainer.appendChild(item);
                    });
                } else {
                    // Se não houver eventos, cria uma mensagem indicando que não há eventos programados
                    var eventContainer = document.getElementById('event-container');
                    eventContainer.innerHTML = ''; // Limpa qualquer conteúdo anterior

                    var noEventMessage = document.createElement('div');
                    noEventMessage.classList.add('no-events');
                    noEventMessage.textContent = "Sem eventos programados.";
                    noEventMessage.style.textAlign = "center";
                    noEventMessage.style.fontSize = "18px";
                    noEventMessage.style.color = "#ff6347"; // Cor do texto (vermelho)

                    eventContainer.appendChild(noEventMessage);
                }
            })
            .catch(error => {
                console.error('Erro ao fazer a requisição:', error);
                var eventContainer = document.getElementById('event-container');
                eventContainer.innerHTML = 'Erro ao carregar os eventos. Tente novamente mais tarde.';
                eventContainer.style.color = 'red';
            });
    }

    // Chama a função para buscar os eventos quando a página carregar
    window.onload = function() {
        fetchEvents();
    };
</script>



<style>
    /* Estilos para diminuir o tamanho da contagem regressiva */
    .countdown {
        font-size: 14px; /* Diminui o tamanho da fonte */
        color: #ff6347; /* Cor da fonte (vermelho) por padrão */
        font-weight: bold; /* Deixa a fonte em negrito */
        margin-top: 10px;
    }

    /* Ajuste de tamanho para dispositivos móveis (opcional) */
    @media (max-width: 600px) {
        .countdown {
            font-size: 12px; /* Reduz ainda mais o tamanho em telas pequenas */
        }
    }
</style>



</html>
