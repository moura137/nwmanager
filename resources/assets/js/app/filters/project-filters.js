angular.module('app.filters')
.filter('statusClassProject', function() {
  return function(input) {
    if (input !== void 0) {
        switch(input) {
            case '1': //Ativo
                return 'primary';

            case '2': // Encerrado
                return 'danger';

            case '3': // Pausado
                return 'warning';

            default: // Inativo
                return 'default';
        }
    }
  };
})

.filter('statusProject', function() {
  return function(input) {
    if (input !== void 0) {
        switch(input) {
            case '1': //Ativo
                return 'Ativo';

            case '2': // Encerrado
                return 'Encerrado';

            case '3': // Pausado
                return 'Pausado';

            default: // Inativo
                return 'Inativo';
        }
    }
  };
})

.filter('displaySize', function() {
  return function(input) {
    if (input !== void 0) {
        prefix = 'bytes';
        if (input >= 1024) {
            prefix = 'KB';
            input = input / 1024;
        }

        if (input >= 1024) {
            prefix = 'MB';
            input = input / 1024;
        }

        if (input >= 1024) {
            prefix = 'GB';
            input = input / 1024;
        }

        input = Math.round(input * 100) / 100

        return input + prefix;
    }
  };
})

.filter('iconFile', function() {
  return function(extension) {
    icon = 'fa-file-o';

    if (extension !== void 0) {
        switch(extension) {
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'png':
            case 'bmp':
                icon = 'fa-file-image-o';
            break;

            case 'pdf':
                icon = 'fa-file-pdf-o';
            break;

            case 'zip':
            case 'rar':
            case 'tar.gz':
                icon = 'fa-file-zip-o';
            break;

            case 'txt':
                icon = 'fa-file-text-o';
            break;

            case 'doc':
            case 'docx':
                icon = 'fa-file-word-o';
            break;

            case 'xls':
            case 'xlsx':
            case 'csv':
                icon = 'fa-file-excel-o';
            break;

            case 'mp3':
                icon = 'fa-file-sound-o';
            break;

            case 'mp4':
            case 'avi':
            case 'mpg':
            case 'mpeg':
                icon = 'fa-file-video-o';
            break;

            default: // Inativo
                icon = 'fa-file-o';
            break;
        }
    }
    return icon;
  };
});