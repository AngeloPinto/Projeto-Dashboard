
// ; --------------------------------- 
// ; Loading 
// ; --------------------------------- 

function loading_start() {

    $('body').loadingModal({
        text: 'processando...'
    });

    var delay = function (ms) {
        return new Promise(function (r) {
            setTimeout(r, ms)
        })
    };

    var time = 0;
    var x = Math.floor((Math.random() * 10) + 1);
    switch(x) {
        case 1:
            var animation = 'rotatingPlane';
            break;
        case 2:
            var animation = 'wave';
            break;
        case 3:
            var animation = 'wanderingCubes';
            break;
        case 4:
            var animation = 'spinner';
            break;
        case 5:
            var animation = 'chasingDots';
            break;
        case 6:
            var animation = 'threeBounce';
            break;
        case 7:
            var animation = 'circle';
            break;
        case 8:
            var animation = 'cubeGrid';
            break;
        case 9:
            var animation = 'fadingCircle';
            break;
        case 10:
            var animation = 'foldingCube';
            break;
        default:
            var animation = 'foldingCube';
            break;
      }     

    var animation = 'wanderingCubes';

    delay(time)
        .then(function () {
            $('body').loadingModal('animation', animation).loadingModal('backgroundColor', 'black').loadingModal('color', 'white');
            return delay(time);
        });
}



function loading_stop() {

    var delay = function (ms) {
        return new Promise(function (r) {
            setTimeout(r, ms)
        })
    };
    var time = 0;
    delay(time).then(function() { $('body').loadingModal('destroy'); } );
}