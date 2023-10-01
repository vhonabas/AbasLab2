<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        #player-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        audio {
            width: 100%;
            margin-top: 20px;
        }

        #playlist {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        #playlist li {
            cursor: pointer;
            padding: 10px;
            background-color: #eee;
            margin: 5px 0;
            transition: background-color 0.2s ease-in-out;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #playlist li:hover {
            background-color: #ddd;
        }

        #playlist li.active {
            background-color: #333;
            color: #fff;
        }

        .modal-content {
            background-color: #fff;
        }

        .btn-close {
            color: #333;
        }

        .modal-footer .btn-secondary {
            background-color: #333;
            color: #fff;
        }

        .modal-footer .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <div id="player-container">
        <h1>Music Player</h1>

        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                My Playlist
            </button>
        </div>

        <form action="/search" method="get" class="mt-3">
            <div class="input-group">
                <input type="search" name="search" class="form-control" placeholder="Search a song" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <h3 class="mt-3">Upload a Song:</h3>
        <form action="/addsong" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input type="file" id="myfile" name="myfile" accept=".mp3" class="form-control">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>

        <audio id="audio" controls autoplay></audio>
        <ul id="playlist">
            <?php if ($mus): ?>
                <?php foreach ($mus as $music):?>
                    <li data-src="<?=base_url(); ?>/music/<?= $music['musicname']; ?>.mp3"><?= $music['musicname']; ?>
                        <a href="/addtoplaylist" class="hover-effect">
                            <img src="<?=base_url(); ?>/add.png">
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else:?>
                <?php foreach ($music as $m):?>
                    <li data-src="<?=base_url(); ?>/music/<?= $m['musicname']; ?>.mp3"><?= $m['musicname']; ?>
                        <a href="/addtoplaylist" class="hover-effect">
                            <img src="<?=base_url(); ?>/add.png">
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function () {
        const audio = document.getElementById('audio');
        const playlist = document.getElementById('playlist');
        const playlistItems = playlist.querySelectorAll('li');
        let currentTrack = 0;

        function playTrack(trackIndex) {
            if (trackIndex >= 0 && trackIndex < playlistItems.length) {
                const track = playlistItems[trackIndex];
                const trackSrc = track.getAttribute('data-src');
                audio.src = trackSrc;
                audio.play();
                currentTrack = trackIndex;
            }
        }

        function nextTrack() {
            currentTrack = (currentTrack + 1) % playlistItems.length;
            playTrack(currentTrack);
        }

        function previousTrack() {
            currentTrack = (currentTrack - 1 + playlistItems.length) % playlistItems.length;
            playTrack(currentTrack);
        }

        playlistItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                playTrack(index);
            });
        });

        audio.addEventListener('ended', () => {
            nextTrack();
        });

        playTrack(currentTrack);
    });
</script>
<!-- Rest of your modals and scripts remain unchanged -->
</body>
</html>
