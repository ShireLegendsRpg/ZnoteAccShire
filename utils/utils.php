<?php

// Função para calcular a diferença de dias entre o valor do tick e a data atual
function calculateDaysDifference($tick) {
    // Verifica se o tick não é 0
    if ($tick != 0) {
        // Obter o timestamp atual
        $currentTimestamp = time();

        // Calcular a diferença em segundos
        $diffInSeconds = $currentTimestamp - $tick;

        // Converter a diferença para dias
        $diffInDays = floor($diffInSeconds / (60 * 60 * 24)); // 60 segundos * 60 minutos * 24 horas

		if($diffInDays <= 0){
			return 0;
		}

        return $diffInDays;
    } else {
        return 0; // Retorna null se o tick for 0
    }
}
?>
