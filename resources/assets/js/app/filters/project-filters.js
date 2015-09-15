angular.module('app.filters')
.filter('statusClassProject', ['Settings', function(Settings) {
  return function(input) {
    if (input !== void 0) {
        style = 'default';
        Settings.project.status.some(function(elem){
            if (elem.value == input) {
                style = elem.style;
                return true;
            }
        });

        return style;
    }
  };
}])

.filter('statusProject', ['Settings', function(Settings) {
  return function(input) {
    if (input !== void 0) {
        label = 'Inativo';
        Settings.project.status.some(function(elem){
            if (elem.value == input) {
                label = elem.label;
                return true;
            }
        });

        return label;
    }
  };
}])

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