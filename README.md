# GameStatus

A small and easy to use Javascript gameserver query

## Requirements

- A webserver which supports PHP and Sockets/fsockopen

## Usage

- Upload to webhost
- Download [gsquery](https://github.com/nikkii/gsquery) and put it into 'includes/gsquery/'
- Create a div with the following format

	<div class="serverstatus" data-address="example.com:27015" type="halflife"></div>
	<script src="js/jquery.js"></script>
	<script src="js/gamestatus.js"></script>

- OR call it manually

	<div class="bla"></div>
	<script src="js/jquery.js"></script>
	<script src="js/gamestatus.js"></script>
	<script>
		$('.bla').checkStatus({
			address : 'example.com:27015',
			type : 'halflife'
		});
	</script>
	
## License

Copyright (c) 2013, Nikki (nospam at nikkii.us)
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.