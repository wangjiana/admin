(function () {
    'use strict';

    $("input[type='number']").keydown(function (e) {
        if (e.keyCode == 69 || e.keyCode == 187 || e.keyCode == 189 || e.keyCode == 110) {
            return false;
        }

        if ($(this).val().length >= 9 && e.keyCode != 8) {
            return false;
        }
    });
})();


var Util = {
    /**
     * 查询搜索栏字符串值(无参数返回所有值)
     * @param search
     * @return mix[String|Array]
     */
    queryStringParameters: function (search) {
        var params = location.search.substr(1);
        var paramsArray = params.split('&');
        var tempArray = [];
        for (var i = 0; i < paramsArray.length; i++) {
            var value = paramsArray[i].split('=');
            tempArray[value[0]] = value[1];
        }

        if (search) {
            return tempArray[search];
        } else {
            return tempArray;
        }
    },
    /**
     * 获取当前时间(年月日时分秒)
     * @return {string}
     */
    getDate: function () {
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    },
    /**
     * 增加天数
     * @param rawDate
     * @param days
     * @return {string}
     */
    addDays: function (rawDate, days) {
        var millisec = Date.parse(rawDate);
        var add_ms = parseInt(days) * 86400000;
        var date = new Date(millisec + add_ms).toLocaleDateString();
        return date.replace(/\//g, '-');
    }
};