<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zone Analyzer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('imagens/black-370118_1920.png'); /* Caminho para a imagem de background */
            background-size: cover;
            background-position: center;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-field {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .result-container {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        #logout-btn {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        #logout-btn:hover {
            background-color: #d32f2f;
        }

        .how-to-play {
            margin-top: 20px;
            padding: 10px;
            background-color: #e0e0e0;
            border-radius: 8px;
        }
        .how-to-play h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .how-to-play p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Zone Analyzer</h1>

        <div class="result-container">
            <div class="label">Results collected (<span id="result-count">0</span>):</div>
            <div id="result-list"></div>
        </div>

        <div class="result-container">
            <div class="label">Zones:</div>
            <div id="zone-list"></div>
        </div>

        <div class="result-container">
            <button class="btn" onclick="addNumbers()">Add</button>
            <button class="btn" onclick="analyzeZones()">Analyze</button>
            <button class="btn" onclick="clearResults()">Clear</button>
        </div>

      

        <div class="how-to-play">
            <h3>How to play:</h3>
            <p><strong>English:</strong></p>
            <ul>
                <li>Add the numbers from the roulette history separated by commas and without spaces, like this: 10,32,14,15,16,25</li>
                <li>Play with a maximum of 2 neighbors, or with 1 neighbor. It's also possible.</li>
                <li>Try not to exceed the number of 60 - 80 results collected (it starts to become less accurate)</li>
                <li>For help and more information: telegram @carloscorr3a</li>
            </ul>
            <p><strong>Português:</strong></p>
            <ul>
                <li>Adicione os números do histórico da roleta separados por vírgulas e sem espaços, como: 10,32,14,15,16,25</li>
                <li>Jogue com um máximo de 2 vizinhos, ou com 1 vizinho. Também é possível.</li>
                <li>Tente não exceder o número de 60 - 80 resultados coletados (começa a ficar menos preciso)</li>
                <li>Para ajuda e mais informações: telegram @carloscorr3a</li>
            </ul>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <button id="logout-btn" onclick="logout()">Logout</button>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <p>Copyright © @carloscorr3a</p>
        </div>
    </div>

    <script>
        let resultados = [];

        // Função para adicionar números
        function addNumbers() {
            let numerosStr = prompt("Enter numbers separated by commas:");
            if (numerosStr) {
                let numeros = numerosStr.split(',').map(num => parseInt(num.trim()));
                resultados.push(...numeros);
                updateResultados();
            }
        }

        // Função para calcular zonas mais frequentes
        function analyzeZones() {
            let frequenciaZonas = {};
            const zonas = {
                0: [26, 32, 0, 15, 3],
                1: [20, 14, 1, 33, 16],
                2: [21, 25, 2, 4, 17],
                3: [26, 35, 3, 0, 12],
                4: [21, 19, 4, 2, 15],
                5: [24, 10, 5, 23, 16],
                6: [27, 13, 6, 34, 17],
                7: [28, 12, 7, 29, 18],
                8: [23, 30, 8, 10, 11],
                9: [22, 31, 9, 18, 14],
                10: [5, 23, 10, 8, 24],
                11: [30, 36, 11, 8, 13],
                12: [7, 28, 12, 35, 3],
                13: [36, 27, 13, 11, 6],
                14: [31, 9, 14, 20, 1],
                15: [19, 32, 15, 0, 4],
                16: [33, 1, 16, 24, 5],
                17: [34, 6, 17, 2, 25],
                18: [29, 7, 18, 22, 9],
                19: [4, 15, 19, 21, 32],
                20: [14, 31, 20, 1, 33],
                21: [2, 4, 21, 19, 25],
                22: [9, 18, 22, 29, 31],
                23: [8, 10, 23, 5, 30],
                24: [5, 16, 24, 10, 33],
                25: [2, 17, 25, 21, 34],
                26: [0, 3, 26, 32, 35],
                27: [6, 13, 27, 34, 36],
                28: [7, 12, 28, 29, 35],
                29: [18, 7, 29, 28, 22],
                30: [23, 36, 30, 11, 8],
                31: [14, 9, 31, 20, 22],
                32: [15, 19, 32, 0, 26],
                33: [16, 1, 33, 24, 20],
                34: [17, 6, 34, 27, 25],
                35: [26, 3, 35, 12, 28],
                36: [13, 27, 36, 11, 30]
            };

            // Conta a frequência de cada zona nos resultados coletados
            resultados.forEach(resultado => {
                Object.keys(zonas).forEach(zona => {
                    if (zonas[zona].includes(resultado)) {
                        frequenciaZonas[zona] = (frequenciaZonas[zona] || 0) + 1;
                    }
                });
            });

            // Ordena as zonas pela frequência (do maior para o menor)
            let zonasOrdenadas = Object.entries(frequenciaZonas)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 5)
                .map(entry => parseInt(entry[0]));

            // Atualiza a lista de zonas mais frequentes
            document.getElementById('zone-list').textContent = zonasOrdenadas.join(', ');
        }

        // Função para limpar os resultados
        function clearResults() {
            resultados = [];
            updateResultados();
        }

        // Função para atualizar a lista de resultados
        function updateResultados() {
            document.getElementById('result-count').textContent = resultados.length;
            document.getElementById('result-list').textContent = resultados.join(', ');
        }

        // Função para logout
        function logout() {
            // Redireciona para a página de login
            window.location.href = 'login.php';
        }
    </script>
</body>
</html>
