/*jslint browser:true */
/*global $, jQuery, console, alert*/

/**
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

var akswSearchRenderItem = function (title, url, content) {
    'use strict';
    var html = '';
    html += '<div class="searchresult abstract">';
    html += '<h2><a href="' + url + '">' + title + '</a></h2>';
    html += '<code>' + url + '</code>';
    html += '<p class="abstract">' + content + '</p>';
    html += '</div>';
    return html;
};

var akswSearchRender = function (data) {
    'use strict';
    //console.log(data);
    $('#content').empty();
    $('#content').append('<header class="intro"><h1>Search Results</h1></header>');
    $('#content').append('<div class="query-list-abstract" id="searchresults" />');
    $(data).each(function () {
        var title = this.titleNoFormatting,
            url = this.url,
            content = this.content,
            html = akswSearchRenderItem(title, url, content);
        $('#searchresults').append(html);
    });
};

/*
 * based on the tutorial from
 * http://tutorialzine.com/2010/09/google-powered-site-search-ajax-jquery/
 *
 * TODO: check for errors and warnings
 */
var akswSearchQuery = function (query, start) {
    'use strict';
    // Google's AJAX search API
    var apiURL = 'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&callback=?',
        requestData = {
            q   : 'site:aksw.org ' + query,
            rsz : 8,
            start : start
        };

    $.ajax({
        url: apiURL,
        dataType: 'json',
        data: requestData,
        success: function (data) {
            akswSearchRender(data.responseData.results);
        }
    });

    //$.getJSON(apiURL, {
        //q   : 'site:aksw.org ' + query,
        //rsz : 8,
        //start : start
    //}, function (data) {
        //akswSearchRender(data.responseData.results);
    //});
};

$(document).ready(function () {
    'use strict';
    $('#search').submit(function () {
        // event.preventDefault();
        var query = $('#searchterm').prop('value');
        akswSearchQuery(query, 0);
        return false;
    });
});

