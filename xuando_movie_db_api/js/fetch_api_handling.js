// Author: Xuan Do

/*************
SAMPLE URLS

1. To get the config data like image base urls
https://api.themoviedb.org/3/configuration?api_key=<APIKEY>

2. To fetch a list of movies based on a keyword
https://api.themoviedb.org/3/search/movie?api_key=<APIKEY>&query=<keyword>

3. To fetch more details about a movie
https://api.themoviedb.org/3/movie/<movie-id>?api_key=<APIKEY>

4. To fetch a list of movies based on a genre
https://api.themoviedb.org/3/discover/movie?api_key=<APIKEY>&with_genres=<myGenreId>

5. To fetch a list of official genres for movies.
https://api.themoviedb.org/3/genre/movie/list?api_key=<APIKEY>

*************/
// const APIKEY is inside key.js
let baseURL = 'https://api.themoviedb.org/3/';
let configData = null;
let baseImageURL = null;
let moodValue;

// function getConfig() {
let getConfig = function () {
    // Get the correct mood from radio buttons.
    let mood = document.querySelector('input[name = mood]:checked');

    // Check if mood is not equal to null.
    if (!(mood == null)) {
        // outputTable.style.cssText = "display: block;";
        moodValue = mood.value;
    }

    // Connect to TheMovieDB API.
    let url = "".concat(baseURL, 'configuration?api_key=', APIKEY);
    fetch(url)
    .then((result)=>{
        return result.json();
    })
    .then((data)=>{
        baseImageURL = data.images.secure_base_url;
        configData = data.images;
        // runSearch(moodValue)

        if (!(mood == null)) {
            runDiscover(moodValue)
        }

        // runGenres()
    })
    .catch(function(err){
        alert(err);
    });
}

// Use the choosing keyword above to get data from the Movie DB API.
// Discover searching
// https://developers.themoviedb.org/3/discover/movie-discover
let runDiscover = function (keyword) {
    let myGenreId = "";

    // If keyword is 'happy'
    // discover movies with genres 'Comedy'.

    if (keyword == "happy") {
        myGenreId = 35;
    }

    // If keyword is 'sad'
    // discover movies with genres 'Drama'.
    else if (keyword == "sad") {
        myGenreId = 18;
    }

    // If keyword is 'anger'
    // discover movies with genres 'Thriller'.
    else if (keyword == "anger") {
        myGenreId = 53;
    }

    // If keyword is 'calm'
    // discover movies with genres 'Animation'.
    else if (keyword == "calm") {
        myGenreId = 16;
    }

    // If keyword is 'romantic'
    // discover movies with genres 'Romance'.
    else if (keyword == "romantic") {
        myGenreId = 10749;
    }

    // If keyword is 'playful'
    // discover movies with genres 'Adventure'.
    else if (keyword == "playful") {
        myGenreId = 12;
    }

    // If keyword is 'confident'
    // discover movies with genres 'Action'.
    else if (keyword == "confident") {
        myGenreId = 28;
    }

    // If keyword is 'focus'
    // discover movies with genres 'Documentary'.
    else if (keyword == "focus") {
        myGenreId = 99;
    }

    // Genre searching
    let url = ''.concat(baseURL, 'discover/movie?api_key=', APIKEY, '&with_genres=', myGenreId);

    fetch(url)
    .then(result=>result.json())
    .then((data)=>{
        console.log(data.results);

        // Work with results array...
        if (data.results.length > 0) {
            for (let i = 0; i < 5; i++) {
                // console.log(data.results[i].title);
                // console.log(data.results[i].overview);
                // console.log(data.results[i].poster_path);

                let sendTitle = "";
                let sendOverview = "";
                let sendPoster_path = "";
                let sendGenre= "";

                sendTitle = data.results[i].title;
                sendOverview = data.results[i].overview;

                console.log(data.results[i].poster_path);

                if (data.results[i].poster_path != null) {
                    sendPoster_path = 'https://image.tmdb.org/t/p/w185' + data.results[i].poster_path;
                }

                if (myGenreId == 35) {
                    sendGenre = "Comedy";
                }
                else if (myGenreId == 18) {
                    sendGenre = "Drama";
                }
                else if (myGenreId == 53) {
                    sendGenre = "Thriller";
                }
                else if (myGenreId == 16) {
                    sendGenre = "Animation";
                }
                else if (myGenreId == 10749) {
                    sendGenre = "Romance";
                }
                else if (myGenreId == 12) {
                    sendGenre = "Adventure";
                }
                else if (myGenreId == 28) {
                    sendGenre = "Action";
                }
                else if (myGenreId = 99) {
                    sendGenre = "Documentary";
                }


                // Front-end (Static) -- Display on the websites.
                document.getElementById('fetch-title ' + i).innerHTML = sendTitle;
                document.getElementById('fetch-overview ' + i).innerHTML = sendOverview;
                document.getElementById('fetch-image ' + i).src = sendPoster_path;


                // Pass variable from javascript to PHP.

                // Send to store in database only if the URL of the image is not null.
                if (data.results[i].poster_path != null) {
                    storeDataIntoDb(sendTitle, sendOverview, sendPoster_path, moodValue, sendGenre);
                }
            }
        }
    })
}

// Genre searching
// https://developers.themoviedb.org/3/genres/get-movie-list
let runGenres = function () {
    let url = ''.concat(baseURL, 'genre/movie/list?api_key=', APIKEY);

    fetch(url)
    .then(result=>result.json())
    .then((data)=>{
        // Process the returned data

        console.log(data.genres);

        /*******************************
        SAMPLE SEARCH RESULTS DATA

        0: {id: 28, name: "Action"}
        1: {id: 12, name: "Adventure"}
        2: {id: 16, name: "Animation"}
        3: {id: 35, name: "Comedy"}
        4: {id: 80, name: "Crime"}
        5: {id: 99, name: "Documentary"}
        6: {id: 18, name: "Drama"}
        7: {id: 10751, name: "Family"}
        8: {id: 14, name: "Fantasy"}
        9: {id: 36, name: "History"}
        10: {id: 27, name: "Horror"}
        11: {id: 10402, name: "Music"}
        12: {id: 9648, name: "Mystery"}
        13: {id: 10749, name: "Romance"}
        14: {id: 878, name: "Science Fiction"}
        15: {id: 10770, name: "TV Movie"}
        16: {id: 53, name: "Thriller"}
        17: {id: 10752, name: "War"}
        18: {id: 37, name: "Western"}

        *******************************/
    })
}


let runSearch = function (keyword) {
    // https://developers.themoviedb.org/3/search/search-movies
    // Search for movies.
    // Search keyword will match the title of the movie.
    let url = ''.concat(baseURL, 'search/movie?api_key=', APIKEY, '&query=', keyword);

    fetch(url)
    .then(result=>result.json())
    .then((data)=>{
        // Process the returned data
        // document.getElementById('output').innerHTML = JSON.stringify(data, null, 4);

        // Work with results array...

        let myTitles = "";
        let myOverviews = "";
        let myPoster_paths = "";

        if (data.results.length > 0) {
            for (let i = 0; i < 5; i++) {
                myTitles += data.results[i].title + "\n";
                myOverviews += data.results[i].overview + "\n";
                myPoster_paths += 'https://image.tmdb.org/t/p/w185' + data.results[i].poster_path + " ";
            }

            let myTitle = "";
            let myOverview = "";
            let myPoster_path = "";

            for (let i = 0; i < 5; i++) {
                myTitle = myTitles.split("\n")[i];
                document.getElementById('fetch-title ' + i).innerHTML = myTitle;
                myOverview = myOverviews.split("\n")[i];
                document.getElementById('fetch-overview ' + i).innerHTML = myOverview;
                myPoster_path = myPoster_paths.split(" ")[i];
                document.getElementById('fetch-image ' + i).src = myPoster_path;

                // Pass variable from javascript to PHP.
            }
        }
    })
}

document.addEventListener('DOMContentLoaded', getConfig);
/*******************************
SAMPLE SEARCH RESULTS DATA
{ "vote_count": 2762,
    "id": 578,
    "video": false,
    "vote_average": 7.5,
    "title": "Jaws",
    "popularity": 16.273358,
    "poster_path": "/l1yltvzILaZcx2jYvc5sEMkM7Eh.jpg",
    "original_language": "en",
    "original_title": "Jaws",
    "genre_ids": [ 27, 53, 12 ],
    "backdrop_path": "/slkPgAt1IQgxZXNrazEcOzhAK8f.jpg",
    "adult": false,
    "overview": "An insatiable great white shark terrorizes the townspeople of Amity Island, The police chief, an oceanographer and a grizzled shark hunter seek to destroy the bloodthirsty beast.",
    "release_date": "1975-06-18"
}
*******************************/

// -----------------------------------------------------------------------------
// Store data into the database.
// -----------------------------------------------------------------------------
let storeDataIntoDb = function (mTitle, mOverview, mPoster_path, mMood, mGenre)
{
    // https://developer.mozilla.org/en-US/docs/Web/API/FormData
    var fd = new FormData();

    fd.append('action', 'add_movie');

    fd.append('title', mTitle);
    fd.append('overview', mOverview);
    fd.append('poster_path', mPoster_path);
    fd.append('mood', mMood);
    fd.append('genre', mGenre);

    console.log(fd.getAll('action'));

    // Create Ajax request.
    var xhr = new XMLHttpRequest();

    if (xhr == null) {
        alert('Connection failed!');
        return;
    }

    xhr.open('POST', 'action.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 0 ) {
            console.log("state 0");
        }
        if (xhr.readyState === 1 ) {
            console.log("state 1");
        }
        if (xhr.readyState === 2 ) {
            console.log("state 2");
        }
        if (xhr.readyState === 3 ) {
            console.log("state 3");
        }
        if (xhr.readyState === 4 ) {
            console.log("state 4");
            if (xhr.status === 200) {
                console.log("status 200");
            } else {
                console.log("Data error: " + xhr.status);
            }
        }
    };

    console.log(fd.getAll('title'));
    xhr.send(fd);
}
