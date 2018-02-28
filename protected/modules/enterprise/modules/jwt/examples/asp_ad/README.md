## HumHub - Classic ASP JWT

A JWT implementation in Classic ASP, currently only supports `JWTEncode(dictionary, secret)`.

### Installation

1. Place this script in a folder on your IIS, and disable anonymous access for the script.
2. Change configuration in file jwt_ad.asp

Please note that the ISS does not have to be in the DMZ or in any way accessible via the internet, as the authentication is driven via browser redirects.


### License

The depdendencies in the `lib/external` folder are subject to their respective licenses as noted in the files. This license only pertains to the other files in this repository.

Other files based on `zendesk_jwt_sso_examples` (https://github.com/zendesk/zendesk_jwt_sso_examples).

Copyright 2016 HumHub

Copyright 2013 Zendesk

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.