<?php require_once 'engine/init.php'; include 'layout/overall/header.php';
if ($config['ServerEngine'] == 'TFS_02' || $config['ServerEngine'] == 'TFS_10' || $config['ServerEngine'] == 'OTHIRE') {
$cache = new Cache('engine/cache/killers');
if ($cache->hasExpired()) {
	$killers = fetchMurders();

	$cache->setContent($killers);
	$cache->save();
} else {
	$killers = $cache->load();
}
$cache = new Cache('engine/cache/victims');
if ($cache->hasExpired()) {
	$victims = fetchLoosers();

	$cache->setContent($victims);
	$cache->save();
} else {
	$victims = $cache->load();
}
$cache = new Cache('engine/cache/lastkillers');
if ($cache->hasExpired()) {
	$latests = mysql_select_multi("SELECT `p`.`name` AS `victim`, `d`.`killed_by` as `killed_by`, `d`.`time` as `time` FROM `player_deaths` as `d` INNER JOIN `players` as `p` ON d.player_id = p.id WHERE d.`is_player`='1' ORDER BY `time` DESC LIMIT 20;");
	if ($latests !== false) {
		$cache->setContent($latests);
		$cache->save();
	}
} else {
	$latests = $cache->load();
}
if ($killers) {
?>
<h1>Maiores Matadores</h1>
<table id="killersTable" class="table table-striped">
	<tr class="yellow">
		<th>Nome</th>
		<th>Kills</th>
	</tr>
	<?php foreach ($killers as $killer) {
		echo '<tr>';
		echo "<td width='70%'><a href='characterprofile.php?name=". $killer['killed_by'] ."'>". $killer['killed_by'] ."</a></td>";
		echo "<td width='30%'>". $killer['kills'] ."</td>";
		echo '</tr>';
	} ?>
</table>
<?php
} else echo 'Não existem mortes de jogadores.';

if ($victims) {
?>
<h1>Maiores vítimas</h1>
<table id="victimsTable" class="table table-striped">
	<tr class="yellow">
		<th>Nome</th>
		<th>Mortes</th>
	</tr>
	<?php foreach ($victims as $victim) {
		echo '<tr>';
		echo "<td width='70%'><a href='characterprofile.php?name=". $victim['name'] ."'>". $victim['name'] ."</a></td>";
		echo "<td width='30%'>". $victim['Deaths'] ."</td>";
		echo '</tr>';
	} ?>
</table>
<?php
} else echo 'Não existem mortes de jogadores.';

if ($latests) {
?>
<h1>Últimas Mortes</h1>
<table id="killersTable" class="table table-striped">
	<tr class="yellow">
		<th>Matador</th>
		<th>Horário</th>
		<th>Vítima</th>
	</tr>
	<?php foreach ($latests as $last) {
		echo '<tr>';
		echo "<td width='35%'><a href='characterprofile.php?name=". $last['killed_by'] ."'>". $last['killed_by'] ."</a></td>";
		echo "<td width='30%'>". getClock($last['time'], true) ."</td>";
		echo "<td width='35%'><a href='characterprofile.php?name=". $last['victim'] ."'>". $last['victim'] ."</a></td>";
		echo '</tr>';
	} ?>
</table>
<?php
} else echo 'Não existem mortes de jogadores.';

} else if ($config['ServerEngine'] == 'TFS_03') {
	$cache = new Cache('engine/cache/killers');
	if ($cache->hasExpired()) {
		$deaths = fetchLatestDeaths_03(30, true);
		$cache->setContent($deaths);
		$cache->save();
	} else {
		$deaths = $cache->load();
	}

	if ($deaths && !empty($deaths)) {
	?>
		<h1>Últimos Assassinos</h1>
		<table id="deathsTable" class="table table-striped">
			<tr class="yellow">
				<th>Assassino</th>
				<th>Horário</th>
				<th>Vitima</th>
			</tr>
			<?php foreach ($deaths as $death) {
				echo '<tr>';
				echo "<td><a href='characterprofile.php?name=". $death['killed_by'] ."'>". $death['killed_by'] ."</a></td>";
				echo "<td>". getClock($death['time'], true) ."</td>";
				echo "<td>At level ". $death['level'] .": <a href='characterprofile.php?name=". $death['victim'] ."'>". $death['victim'] ."</a></td>";
				echo '</tr>';
			} ?>
		</table>
		<?php
	} else echo 'No player deaths exist.';
}
include 'layout/overall/footer.php'; ?>
