$(document).ready(function() {
    $('.select2').select2({
      language: "es"
    });
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 60,
        // Título dos botões de navegação
        labelMonthNext: 'Próximo Mes',
        labelMonthPrev: 'Mes anterior',
        // Título dos seletores de mês e ano
        labelMonthSelect: 'Selecione Mes',
        labelYearSelect: 'Selecione Año',
        // Meses e dias da semana
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        // Letras da semana
        weekdaysLetter: ['D', 'L', 'M', 'Mi', 'J', 'V', 'S'],
        //Botões
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Cerrar',
        // max: new Date(((new Date()).getFullYear()), 12, 31),
        // min: -10,
        max: true,
        // Formato da data que aparece no input
        format: 'yyyy-mm-dd',
        // format: 'dddd, dd mmm, yyyy',
        // formatSubmit: 'yyyy/mm/dd',
        // hiddenPrefix: 'prefix__',
        // hiddenSuffix: '__suffix',
        // disable: [
        //   1, 7
        // ],
        onClose: function() {
            $(document.activeElement).blur()
        }
    });
    $('.atepic').pickadate({
        selectMonths: true,
        selectYears: 60,
        // Título dos botões de navegação
        labelMonthNext: 'Próximo Mes',
        labelMonthPrev: 'Mes anterior',
        // Título dos seletores de mês e ano
        labelMonthSelect: 'Selecione Mes',
        labelYearSelect: 'Selecione Año',
        // Meses e dias da semana
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        // Letras da semana
        weekdaysLetter: ['D', 'L', 'M', 'Mi', 'J', 'V', 'S'],
        //Botões
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Cerrar',
        //   max: new Date(((new Date()).getFullYear()), 12, 31),
        min: -10,
        // max: true,
        // Formato da data que aparece no input
        format: 'yyyy-mm-dd',
        // format: 'dddd, dd mmm, yyyy',
        // formatSubmit: 'yyyy/mm/dd',
        // hiddenPrefix: 'prefix__',
        // hiddenSuffix: '__suffix',
        // disable: [
        //   1, 7
        // ],
        onClose: function() {
            $(document.activeElement).blur()
        }
    });
    $(".datepicker").keypress(function(evt) {
        return false;
    });
    // $('.dataTables_length select').addClass('browser-default');
    function logoTecnoparque() {
        let logoTecnoparque = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAABLCAYAAAAGeD98AAAACXBIWXMAAC4jAAAuIwF4pT92AAA7M2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMwMTQgNzkuMTU2Nzk3LCAyMDE0LzA4LzIwLTA5OjUzOjAyICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgICAgICAgICAgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIgogICAgICAgICAgICB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIKICAgICAgICAgICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgICAgICAgICAgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmV4aWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vZXhpZi8xLjAvIj4KICAgICAgICAgPHhtcDpDcmVhdG9yVG9vbD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxNCAoV2luZG93cyk8L3htcDpDcmVhdG9yVG9vbD4KICAgICAgICAgPHhtcDpDcmVhdGVEYXRlPjIwMTgtMTEtMDZUMTQ6MTk6MTctMDU6MDA8L3htcDpDcmVhdGVEYXRlPgogICAgICAgICA8eG1wOk1vZGlmeURhdGU+MjAxOC0xMS0wNlQxNjowMzo0NC0wNTowMDwveG1wOk1vZGlmeURhdGU+CiAgICAgICAgIDx4bXA6TWV0YWRhdGFEYXRlPjIwMTgtMTEtMDZUMTY6MDM6NDQtMDU6MDA8L3htcDpNZXRhZGF0YURhdGU+CiAgICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2UvcG5nPC9kYzpmb3JtYXQ+CiAgICAgICAgIDxwaG90b3Nob3A6Q29sb3JNb2RlPjM8L3Bob3Rvc2hvcDpDb2xvck1vZGU+CiAgICAgICAgIDxwaG90b3Nob3A6VGV4dExheWVycz4KICAgICAgICAgICAgPHJkZjpCYWc+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8cGhvdG9zaG9wOkxheWVyTmFtZT5Db2xvbWJpYTwvcGhvdG9zaG9wOkxheWVyTmFtZT4KICAgICAgICAgICAgICAgICAgPHBob3Rvc2hvcDpMYXllclRleHQ+Q29sb21iaWE8L3Bob3Rvc2hvcDpMYXllclRleHQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICA8L3JkZjpCYWc+CiAgICAgICAgIDwvcGhvdG9zaG9wOlRleHRMYXllcnM+CiAgICAgICAgIDx4bXBNTTpJbnN0YW5jZUlEPnhtcC5paWQ6NjBjOGEwMGUtNDQxNC1kZjRmLTkxNWYtNzE2NzBjNjFkNmE0PC94bXBNTTpJbnN0YW5jZUlEPgogICAgICAgICA8eG1wTU06RG9jdW1lbnRJRD5hZG9iZTpkb2NpZDpwaG90b3Nob3A6NmEwZWFmZGQtZTIwNy0xMWU4LTkwNjYtYzZjYzY3NjZiYjk0PC94bXBNTTpEb2N1bWVudElEPgogICAgICAgICA8eG1wTU06T3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6OTljY2U1OTQtOWZlNS0xNDQ4LTgzNjctM2UwMGIzMmY5Njc2PC94bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpIaXN0b3J5PgogICAgICAgICAgICA8cmRmOlNlcT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+Y3JlYXRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOjk5Y2NlNTk0LTlmZTUtMTQ0OC04MzY3LTNlMDBiMzJmOTY3Njwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxOC0xMS0wNlQxNDoxOToxNy0wNTowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKFdpbmRvd3MpPC9zdEV2dDpzb2Z0d2FyZUFnZW50PgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo2MGM4YTAwZS00NDE0LWRmNGYtOTE1Zi03MTY3MGM2MWQ2YTQ8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTgtMTEtMDZUMTY6MDM6NDQtMDU6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE0IChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOlNlcT4KICAgICAgICAgPC94bXBNTTpIaXN0b3J5PgogICAgICAgICA8dGlmZjpPcmllbnRhdGlvbj4xPC90aWZmOk9yaWVudGF0aW9uPgogICAgICAgICA8dGlmZjpYUmVzb2x1dGlvbj4zMDAwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj4zMDAwMDAwLzEwMDAwPC90aWZmOllSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpSZXNvbHV0aW9uVW5pdD4yPC90aWZmOlJlc29sdXRpb25Vbml0PgogICAgICAgICA8ZXhpZjpDb2xvclNwYWNlPjY1NTM1PC9leGlmOkNvbG9yU3BhY2U+CiAgICAgICAgIDxleGlmOlBpeGVsWERpbWVuc2lvbj41MTI8L2V4aWY6UGl4ZWxYRGltZW5zaW9uPgogICAgICAgICA8ZXhpZjpQaXhlbFlEaW1lbnNpb24+NzU8L2V4aWY6UGl4ZWxZRGltZW5zaW9uPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAKPD94cGFja2V0IGVuZD0idyI/PhwU4cwAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOgAAFIIAAEVWAAAOpcAABdv11ofkAAALddJREFUeNrsfWtwHNd15jcgwZdIYSCStixKnBGl1liS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';
        return logoTecnoparque;
    }
});

function checkSubmit() {
    console.log('Clickeando');
    $('input[type="text"]').keypress(function() {
        if ($(this).val() != '') {
            $('button[type="submit"]').removeAttr('disabled');
        }
    });
    $('button[type="submit"]').attr('disabled', 'disabled');
    return true;
}