require.config({paths:{sulutag:"../../sulutag/dist","type/tagList":"../../sulutag/dist/validation/types/tagList"}}),define({name:"SuluTagBundle",initialize:function(a){"use strict";var b=a.sandbox;a.components.addSource("sulutag","/bundles/sulutag/dist/components"),b.mvc.routes.push({route:"settings/tags",callback:function(){return'<div data-aura-component="tags@sulutag" data-aura-display="list"/>'}})}});