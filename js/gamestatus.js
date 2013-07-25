/*
 *  GameStatus (jQuery Plugin)
 *  Copyright (C) 2013 Nikki <nikki@nikkii.us>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
!function ($) {

	$.fn.checkStatus = function (options) {
		var defaults = {
			address: "localhost:27015",
			autoupdate: true,
			updatetime: 30000,
			queryUrl: 'gamestatus.php',
			html: {
				halflife2 : '<a href="steam://connect/%ipport%"><strong>%name%</strong></a><br />Map: %map%<br />Players: %totalplayers%/%maxplayers%',
				minecraft : '<a href="#"><strong>%hostname%</strong></a><br />IP: %hostip%:%hostport%<br />Version: %version%<br />Game type: %gametype%<br />Players: %numplayers%/%maxplayers%'
			},
			callback: false
		};
		var opts = $.extend(defaults, options);
		
		return this.each(function () {
			var $this = $(this);
			
			var type = 'halflife2';
			if($this.data("type")) {
				type = $this.data("type");
			}
			var addr = $this.data("address");
			if(addr) {
				opts.address = addr;
			}
			if(opts.address) {
				$.getJSON(opts.queryUrl, { address: opts.address, type: type }, function(response) {
					if(opts.callback) {
						opts.callback(response);
					} else {
						$this.html(opts.html[type].replace(/%(.*?)%/g, function(s, key) {
							return response[key];
						}));
					}
				});
			}
			if(opts.autoupdate) {
				setTimeout(function() {
					$this.checkStatus(options);
				}, opts.updatetime);
			}
		})
	}


	/* APPLY TO STANDARD STATUS ELEMENTS
	 * =================================== */

	$(function () {
		$(".serverstatus").each(function(index) {
			$(this).html("Querying...").checkStatus();
		});
	})

}(window.jQuery);