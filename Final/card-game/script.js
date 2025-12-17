let difficulty = "normal";
let maxSelection = 3;
let playerTeam = [];
let opponentTeam = [];
let currentRound = 0;
let currentWinStreak = parseInt(localStorage.getItem("currentWinStreak") || "0");
let highestWinStreak = parseInt(localStorage.getItem("highestWinStreak") || "0");

const typeAdvantages = {
    fire: ["grass"],
    water: ["fire"],
    grass: ["water"],
    rock: ["fire", "flying"],
    flying: ["grass", "fighting"],
    fighting: ["rock"]
};
let winSound = new Audio("images/correct.wav");
let loseSound = new Audio("images/wrong.wav");
let gameStart = document.getElementById("gameStart");
let selectionScreen = document.getElementById("selection");
let battleScreen = document.getElementById("battle");
let gameEnd = document.getElementById("gameEnd");
let typeChoicesDiv = document.getElementById("typeChoices");
let confirmBtn = document.getElementById("confirmSelection");
let selectedCountEl = document.getElementById("selectedCount");
let selectedTypesDiv = document.getElementById("selectedTypes");
let playerAttackDiv = document.getElementById("playerAttackChoices");
let opponentDiv = document.getElementById("opponentTypes");
let roundResult = document.getElementById("roundResult");
let resultMessage = document.getElementById("resultMessage");
let restartBtn = document.getElementById("restartBtn");
let leaderboardList = document.getElementById("leaderboardList");
let difficultyBtns = document.querySelectorAll(".difficultyBtn");
let playerDisabled = [];
let opponentDisabled = [];

difficultyBtns.forEach(function(btn) {
    btn.addEventListener("click", function() {
        difficulty = btn.dataset.difficulty;
        startSelection();
    });
});

function startSelection() {
    gameStart.style.display = "none";
    selectionScreen.style.display = "flex";
    playerTeam = [];
    playerDisabled = [];
    opponentDisabled = [];
    selectedTypesDiv.innerHTML = "";
    selectedCountEl.textContent = "0";
    confirmBtn.disabled = true;
    var types = [];
    if (difficulty === "hard") {
        for (var key in typeAdvantages) {
            types.push(key);
        }
    } else {
        types = ["fire", "water", "grass"];
    }

    typeChoicesDiv.innerHTML = "";

    for (var i = 0; i < types.length; i++) {
        var type = types[i];
        var img = document.createElement("img");
        img.src = "images/" + type + ".png";
        img.dataset.type = type;
        img.addEventListener("click", function(e) {
            selectType(e.target.dataset.type);
        });
        typeChoicesDiv.appendChild(img);
    }
}

function selectType(type) {
    if (playerTeam.length >= maxSelection) return;
    playerTeam.push(type);
    updateSelectedDisplay();
    confirmBtn.disabled = playerTeam.length < maxSelection;
}
function updateSelectedDisplay() {
    selectedCountEl.textContent = playerTeam.length;
    selectedTypesDiv.innerHTML = "";
    for (var i = 0; i < playerTeam.length; i++) {
        selectedTypesDiv.innerHTML += "<span>" + playerTeam[i] + "</span> ";
    }
}
confirmBtn.addEventListener("click", startBattle);

function startBattle() {
    selectionScreen.style.display = "none";
    battleScreen.style.display = "flex";

    var types = [];
    if (difficulty === "hard") {
        for (var key in typeAdvantages) {
            types.push(key);
        }
    } else {
        types = ["fire", "water", "grass"];
    }

    opponentTeam = [];
    for (var i = 0; i < maxSelection; i++) {
        var randType = types[parseInt(Math.random() *types.length)];
        opponentTeam.push(randType);
    }

    renderTeams();
    roundResult.textContent = "";
}
function renderTeams() {
    opponentDiv.innerHTML = "";
    for (var i = 0; i < opponentTeam.length; i++) {
        var img = document.createElement("img");
        img.src = "images/" + opponentTeam[i] + ".png";
        opponentDiv.appendChild(img);
    }

    playerAttackDiv.innerHTML = "";
    for (var i = 0; i < playerTeam.length; i++) {
        var img = document.createElement("img");
        img.src = "images/" + playerTeam[i] + ".png";
        img.dataset.index = i;
        img.dataset.type = playerTeam[i];

        img.addEventListener("click", function(e) {
            playerAttack(parseInt(e.target.dataset.index), e.target);
        });

        playerAttackDiv.appendChild(img);
    }
}
function playerAttack(idx, imgElement) {
    if (playerDisabled.length >= maxSelection || opponentDisabled.length >= maxSelection){
        return;
    }
    var playerType = playerTeam[idx];
    var availableIndices = [];
    for (var i = 0; i < opponentTeam.length; i++) {
        if (opponentDisabled.indexOf(i) === -1) {
            availableIndices.push(i);
        }
    }
    if (availableIndices.length === 0){ 
        endGame(); 
        return; 
    }

    var opponentIndex = availableIndices[parseInt(Math.random() * availableIndices.length)];
    var opponentType = opponentTeam[opponentIndex];
    var opponentImg = opponentDiv.children[opponentIndex];
    var message = "";
    var playerWins = false;
    var opponentWins = false;

    for (var j = 0; j < (typeAdvantages[playerType] || []).length; j++) {
        if (typeAdvantages[playerType][j] === opponentType) {
            playerWins = true;
        }
    }
    for (var j = 0; j < (typeAdvantages[opponentType] || []).length; j++) {
        if (typeAdvantages[opponentType][j] === playerType) {
            opponentWins = true;
        }
    }
    if (playerWins) {
        message = "WIN — " + playerType + " beats " + opponentType;
        winSound.play();
        disableType(opponentImg);
        opponentDisabled.push(opponentIndex);
    } else if (opponentWins) {
        message = "LOSS — " + opponentType + " beats " + playerType;
        loseSound.play();
        disableType(imgElement);
        playerDisabled.push(idx);
    } else {
        message = "DRAW — " + playerType + " vs " + opponentType;
        loseSound.play();
        disableType(imgElement);
        disableType(opponentImg);
        playerDisabled.push(idx);
        opponentDisabled.push(opponentIndex);
    }

    roundResult.textContent = message;
    if (playerDisabled.length >= maxSelection || opponentDisabled.length >= maxSelection) {
        setTimeout(endGame, 1000);
    }
}

function disableType(img) {
    if (img.src.indexOf("x.png") === -1) {
        img.src = "images/x.png";
        img.style.pointerEvents = "none";
    }
}

function endGame() {
    battleScreen.style.display = "none";
    gameEnd.style.display = "flex";

    var playerWins = opponentDisabled.length >= maxSelection;

    if (playerWins) {
        currentWinStreak++;
        if (currentWinStreak > highestWinStreak) highestWinStreak = currentWinStreak;
        resultMessage.textContent = "You won! Current Streak: " + currentWinStreak + ", Highest: " + highestWinStreak;
    } else {
        currentWinStreak = 0;
        resultMessage.textContent = "You lost! Current Streak reset. Highest: " + highestWinStreak;
    }

    localStorage.setItem("currentWinStreak", currentWinStreak);
    localStorage.setItem("highestWinStreak", highestWinStreak);

    if (currentWinStreak > 0) {
        updateLeaderboard(currentWinStreak);
    }
    renderLeaderboard();
}

function getLeaderboard() {
    var stored = localStorage.getItem("pokemonLeaderboard");
    if (stored) {
        return JSON.parse(stored);
    }
    return [];
}

function updateLeaderboard(score) {
    if (score <= 0) return;

    var topScores = getLeaderboard();
    var name = "Player";
    if (topScores.length < 3 || score > topScores[0].score) {
        name = prompt("Enter your name for the leaderboard:") || "Player";
    }
    topScores.push({ name: name, score: score });

    for (var i = 0; i < topScores.length - 1; i++) {
        for (var j = i + 1; j < topScores.length; j++) {
            if (topScores[j].score > topScores[i].score) {
                var temp = topScores[i];
                topScores[i] = topScores[j];
                topScores[j] = temp;
            }
        }
    }
    while (topScores.length > 3) {
        topScores.pop();
    }

    localStorage.setItem("pokemonLeaderboard", JSON.stringify(topScores));
}
function renderLeaderboard() {
    leaderboardList.innerHTML = "";
    var leaderboard = getLeaderboard();
    for (var i = 0; i < leaderboard.length; i++) {
        var entry = leaderboard[i];
        var li = document.createElement("li");
        li.textContent = (i + 1) + ". " + entry.name + ": " + entry.score;
        leaderboardList.appendChild(li);
    }
}
restartBtn.addEventListener("click", function() {
    location.reload();
});