var face=[
	{title:'任三码',label:[
		{selectarea:{type:'digital',layout:[{title:'第一位', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'第二位', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1},{title:'第三位', no:'01|02|03|04|05|06|07|08|09|10|11', place:2, cols:1},{title:'第四位', no:'01|02|03|04|05|06|07|08|09|10|11', place:3, cols:1},{title:'第五位', no:'01|02|03|04|05|06|07|08|09|10|11', place:4, cols:1}],noBigIndex:5,isButton:true},show_str : 'X,X,X,X,X',code_sp: 's',methodid : 481,name:'任三直选复式',methoddesc:'从第一位、第二位、第三位、第四位、第五位中至少三位上各选1个号码组成一注。',methodhelp:'从第一位、第二位、第三位、第四位、第五位中至少三位上各选1个号码组成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序一致，即为中奖。',methodexample:'投注方案：第一位01 第二位02 第三位03<br>开奖号码：01 02 03 * *，即中任三直选。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任三直选复式'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05',selPosition: true},show_str : 'X',code_sp : ';',methodid : 481,name:'任三直选单式',methoddesc:'手动输入号码，至少输入1个三位数号码组成一注。',methodhelp:'手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中所指定位置的3个号码相同，且顺序一致，即为中奖。',methodexample:'投注方案：第一位01 第二位02 第三位03<br>开奖号码：01 02 03 * *，即中任三直选。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:3,defaultposition:'00111',desc:'任三直选单式'},
		{selectarea:{type: 'digital',layout : [{title:'\u7ec4\u9009', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:3}],noBigIndex : 5,isButton: true,selPosition: true},show_str : 'X',code_sp : ',',methodid : 482,name:'任三组选复式',methoddesc:'从01-11中任意选择3个或3个以上号码。',methodhelp:'从01-11中共11个号码中选择3个号码，所选号码与当期顺序摇出的5个号码中所指定位置的3个号码相同，顺序不限，即为中奖。',methodexample:'投注方案：第一位01 第二位02 第三位03<br>开奖号码：03 01 02 * *（顺序不限），即中任三组选。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:3,defaultposition:'00111',desc:'任三组选复式'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05',selPosition: true},show_str : 'X',code_sp : ';',methodid : 482,name:'任三组选单式',methoddesc:'手动输入号码，至少输入1个三位数号码组成一注。',methodhelp:'手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中所指定位置的3个号码相同，顺序不限，即为中奖。',methodexample:'投注方案：第一位01 第二位02 第三位03<br>开奖号码：03 01 02 * *（顺序不限），即中任三组选。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:3,defaultposition:'00111',desc:'任三组选单式'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true,selPosition: true},show_str : 'X] X',code_sp : ',',methodid : 483,name:'前三组选胆拖',methoddesc:'从01-11中，选取3个及以上的号码进行投注，每注需至少包括1个胆码及2个拖码。',methodhelp:'从01-11中，选取3个及以上的号码进行投注，每注需至少包括1个胆码及2个拖码。<br>所选单注号码与当期顺序摇出的5个号码中所指定位置的3个号码相同，顺序不限，即为中奖。',methodexample:'投注方案：第一位　第二位　第三位　胆码 02，拖码 01 06<br>开奖号码：02 01 06 * *（顺序不限），即中任三组选胆拖。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:3,defaultposition:'00111',desc:'任三组选胆拖'}]},
	{title:'任二码',label:[
		{selectarea:{type:'digital',layout:[{title:'第一位', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'第二位', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1},{title:'第三位', no:'01|02|03|04|05|06|07|08|09|10|11', place:2, cols:1},{title:'第四位', no:'01|02|03|04|05|06|07|08|09|10|11', place:3, cols:1},{title:'第五位', no:'01|02|03|04|05|06|07|08|09|10|11', place:4, cols:1}],noBigIndex:5,isButton:true},show_str : 'X,X,X,X,X',code_sp: 's',methodid : 485,name:'任二直选复式',methoddesc:'从第一位、第二位、第三位、第四位、第五位中至少二位上各选1个号码组成一注。',methodhelp:'从第一位、第二位、第三位、第四位、第五位中至少二位上各选1个号码组成一注，所选号码与开奖号码的指定位置上的号码相同，且顺序一致，即为中奖。',methodexample:'投注方案：第一位01 第二位02<br>开奖号码：01 02 * * *，即中任二直选。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任二直选复式'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05',selPosition: true},show_str : 'X',code_sp : ';',methodid : 485,name:'任二直选单式',methoddesc:'手动输入号码，至少输入1个两位数号码组成一注。',methodhelp:'手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中所指定位置的2个号码相同，且顺序一致，即为中奖。',methodexample:'投注方案：第一位01 第二位02<br>开奖号码：01 02 * * *，即中任二直选。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:2,defaultposition:'00011',desc:'任二直选单式'},
		{selectarea:{type: 'digital',layout : [{title:'组选', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:2}],noBigIndex : 5,isButton: true,selPosition: true},show_str : 'X',code_sp : ',',methodid : 486,name:'任二组选复式',methoddesc:'从01-11中任意选择2个或2个以上号码。',methodhelp:'从01-11中共11个号码中选择2个号码，所选号码与当期顺序摇出的5个号码中所指定位置的2个号码相同，顺序不限，即为中奖。',methodexample:'投注方案：第一位01 第二位02<br>开奖号码：02 01 * * *，（顺序不限），即中任二组选。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:2,defaultposition:'00011',desc:'任二组选复式'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05',selPosition: true},show_str : 'X',code_sp : ';',methodid : 486,name:'任二组选单式',methoddesc:'手动输入号码，至少输入1个两位数号码组成一注。',methodhelp:'手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中所指定位置的2个号码相同，顺序不限，即为中奖。',methodexample:'投注方案：第一位01 第二位02<br>开奖号码：02 01 * * *，（顺序不限），即中任二组选。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:2,defaultposition:'00011',desc:'任二组选单式'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true,selPosition: true},show_str : 'X] X',code_sp : ',',methodid : 487,name:'任二组选胆拖',methoddesc:'从01-11中，选取2个及以上的号码进行投注，每注需至少包括1个胆码及1个拖码。',methodhelp:'从01-11中，选取2个及以上的号码进行投注，每注需至少包括1个胆码及1个拖码。<br>所选单注号码与当期顺序摇出的5个号码中所指定位置的2个号码相同，顺序不限，即为中奖。',methodexample:'投注方案：第一位　第二位　胆码 01，拖码 06<br>开奖号码：06 01 * * *，（顺序不限），即中任二组选胆拖。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:2,defaultposition:'00011',desc:'任二组选胆拖'}]},
	{title:'不定位',label:[
		{selectarea:{type: 'digital',layout : [{title:'不定位', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}],noBigIndex : 5,isButton: true,selPosition: true},show_str : 'X',code_sp : ',',methodid : 489,name:'不定位',methoddesc:'从01-11中任意选择1个或1个以上号码。',methodhelp:'从01-11中共11个号码中选择1个号码，每注由1个号码组成，只要当期顺序摇出的5个号码所指定位置的开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：第一位　第二位　第三位 01<br>开奖号码：01 * * * *，* 01 * * *，* * 01 * *，即中任三位。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:3,defaultposition:'00111',desc:'不定位'}]},
	{title:'定位胆',label:[
		{selectarea:{type: 'digital',layout : [{title:'第一位', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'第二位', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1},{title:'第三位', no:'01|02|03|04|05|06|07|08|09|10|11', place:2, cols:1},{title:'第四位', no:'01|02|03|04|05|06|07|08|09|10|11', place:3, cols:1},{title:'第五位', no:'01|02|03|04|05|06|07|08|09|10|11', place:4, cols:1}],noBigIndex : 5,isButton: true},show_str : 'X,X,X,X,X',code_sp : 's',methodid : 491,name:'定位胆',methoddesc:'从第一位，第二位，第三位，第四位，第五位任意位置上任意选择1个或1个以上号码。',methodhelp:'从第一位，第二位，第三位，第四位，第五位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。',methodexample:'投注方案：第一位 01<br>开奖号码：01 * * * *，即中定位胆。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'定位胆'}]},
	{title:'趣味型',label:[
		{selectarea:{type:'dds',layout: [{title:'', no:'5单0双|4单1双|3单2双|2单3双|1单4双|0单5双', place:0, cols:0}]},show_str : 'X',code_sp : '|',methodid : 493,name:'定单双',methoddesc:'从不同的单双组合中任意选择1个或1个以上的组合。',methodhelp:'从6种单双个数组合中选择1种组合，当期开奖号码的单双个数与所选单双组合一致，即为中奖。',methodexample:'投注方案：5单0双<br>开奖号码：01 03 05 07 09五个单数，即中趣味_定单双。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'定单双'},
		{selectarea:{type: 'digital',layout : [{title:'猜中位', no:'3|4|5|6|7|8|9', place:0, cols:1}],noBigIndex : 3,isButton: true},show_str : 'X',code_sp : ',',methodid : 494,name:'猜中位',methoddesc:'从3-9中任意选择1个或1个以上数字。',methodhelp:'从3-9中选择1个号码进行购买，所选号码与5个开奖号码按照大小顺序排列后的第3个号码相同，即为中奖。',methodexample:'投注方案：08<br>开奖号码：按号码大小顺序排列后04 05 08 09 11，中间数08，即中趣味_猜中位。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'猜中位'}]},
	{title:'任选复式',label:[
		{selectarea:{type: 'digital',layout : [{title:'选1中1', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}],noBigIndex : 5,isButton: true},show_str : 'X',code_sp : ',',methodid : 496,name:'任选一中一',methoddesc:'从01-11中任意选择1个或1个以上号码。',methodhelp:'从01-11共11个号码中选择1个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：05<br>开奖号码：08 04 11 05 03，即中任选一中一。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选一中一'},
		{selectarea:{type: 'digital',layout : [{title:'选2中2', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:2}],noBigIndex : 5,isButton: true},show_str : 'X',code_sp : ',',methodid : 497,name:'任选二中二',methoddesc:'从01-11中任意选择2个或2个以上号码。',methodhelp:'从01-11共11个号码中选择2个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：05 04<br>开奖号码：08 04 11 05 03，即中任选二中二。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选二中二'},
		{selectarea:{type: 'digital',layout : [{title:'选3中3', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:3}],noBigIndex : 5,isButton: true},show_str : 'X',code_sp : ',',methodid : 499,name:'任选三中三',methoddesc:'从01-11中任意选择3个或3个以上号码。',methodhelp:'从01-11共11个号码中选择3个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：05 04 11<br>开奖号码：08 04 11 05 03，即中任选三中三。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选三中三'},
		{selectarea:{type: 'digital',layout : [{title:'选4中4', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:4}],noBigIndex : 5,isButton: true},show_str : 'X',code_sp : ',',methodid : 501,name:'任选四中四',methoddesc:'从01-11中任意选择4个或4个以上号码。',methodhelp:'从01-11共11个号码中选择4个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：05 04 08 03<br>开奖号码：08 04 11 05 03，即中任选四中四。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选四中四'},
		{selectarea:{type: 'digital',layout : [{title:'选5中5', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:5}],noBigIndex : 5,isButton: true},show_str : 'X',code_sp : ',',methodid : 503,name:'任选五中五',methoddesc:'从01-11中任意选择5个或5个以上号码。',methodhelp:'从01-11共11个号码中选择5个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：05 04 11 03 08<br>开奖号码：08 04 11 05 03，即中任选五中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选五中五'},
		{selectarea:{type: 'digital',layout : [{title:'选6中5', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:6}],noBigIndex : 5,isButton: true},show_str : 'X',code_sp : ',',methodid : 505,name:'任选六中五',methoddesc:'从01-11中任意选择6个或6个以上号码。',methodhelp:'从01-11共11个号码中选择6个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：05 10 04 11 03 08<br>开奖号码：08 04 11 05 03，即中任选六中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选六中五'},
		{selectarea:{type: 'digital',layout : [{title:'选7中5', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:7}],noBigIndex : 5,isButton: true},show_str : 'X',code_sp : ',',methodid : 507,name:'任选七中五',methoddesc:'从01-11中任意选择7个或7个以上号码。',methodhelp:'从01-11共11个号码中选择7个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：05 10 04 11 03 08 09<br>开奖号码：08 04 11 05 03，即中任选七中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选七中五'},
		{selectarea:{type: 'digital',layout : [{title:'选8中5', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1, minchosen:8}],noBigIndex : 5,isButton: true},show_str : 'X',code_sp : ',',methodid : 509,name:'任选八中五',methoddesc:'从01-11中任意选择8个或8个以上号码。',methodhelp:'从01-11共11个号码中选择8个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',methodexample:'投注方案：05 10 04 11 03 08 09 01<br>开奖号码：08 04 11 05 03，即中任选八中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选八中五'}]},
	{title:'任选单式',label:[
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05'},show_str : 'X',code_sp : ';',methodid : 496,name:'任选一中一',methoddesc:'手动输入号码，从01-11中任意输入1个号码组成一注。',methodhelp:'从01-11中手动输入1个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',methodexample:'投注方案：05<br>开奖号码：08 04 11 05 03，即中任选一中一。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选一中一'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05'},show_str : 'X',code_sp : ';',methodid : 497,name:'任选二中二',methoddesc:'手动输入号码，从01-11中任意输入2个号码组成一注。',methodhelp:'从01-11中手动输入2个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',methodexample:'投注方案：05 04<br>开奖号码：08 04 11 05 03，即中任选二中二。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选二中二'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05'},show_str : 'X',code_sp : ';',methodid : 499,name:'任选三中三',methoddesc:'手动输入号码，从01-11中任意输入3个号码组成一注。',methodhelp:'从01-11中手动输入3个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',methodexample:'投注方案：05 04 11<br>开奖号码：08 04 11 05 03，即中任选三中三。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选三中三'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05'},show_str : 'X',code_sp : ';',methodid : 501,name:'任选四中四',methoddesc:'手动输入号码，从01-11中任意输入4个号码组成一注。',methodhelp:'从01-11中手动输入4个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',methodexample:'投注方案：05 04 08 03<br>开奖号码：08 04 11 05 03，即中任选四中四。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选四中四'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05'},show_str : 'X',code_sp : ';',methodid : 503,name:'任选五中五',methoddesc:'手动输入号码，从01-11中任意输入5个号码组成一注。',methodhelp:'从01-11中手动输入5个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',methodexample:'投注方案：05 04 11 03 08<br>开奖号码：08 04 11 05 03，即中任选五中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选五中五'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05'},show_str : 'X',code_sp : ';',methodid : 505,name:'任选六中五',methoddesc:'手动输入号码，从01-11中任意输入6个号码组成一注。',methodhelp:'从01-11中手动输入6个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',methodexample:'投注方案：05 10 04 11 03 08<br>开奖号码：08 04 11 05 03，即中任选六中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选六中五'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05'},show_str : 'X',code_sp : ';',methodid : 507,name:'任选七中五',methoddesc:'手动输入号码，从01-11中任意输入7个号码组成一注。',methodhelp:'从01-11中手动输入7个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',methodexample:'投注方案：05 10 04 11 03 08 09<br>开奖号码：08 04 11 05 03，即中任选七中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选七中五'},
		{selectarea:{type:'input',singletypetips:'三码 01 02 03;02 03 04任选 01 02 03 04 05'},show_str : 'X',code_sp : ';',methodid : 509,name:'任选八中五',methoddesc:'手动输入号码，从01-11中任意输入8个号码组成一注。',methodhelp:'从01-11中手动输入8个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',methodexample:'投注方案：05 10 04 11 03 08 09 01<br>开奖号码：08 04 11 05 03，即中任选八中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选八中五'}]},
	{title:'任选胆拖',label:[
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true},show_str : 'X] X',code_sp : ',',methodid : 498,name:'任选二中二',methoddesc:'从01-11中，选取2个及以上的号码进行投注，每注需至少包括1个胆码及1个拖码。',methodhelp:'从01-11共11个号码中选择2个及以上号码进行投注，每注需至少包括1个胆码及1个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',methodexample:'投注方案：胆码 08，托码 06<br>开奖号码：06 08 11 09 02，即中任选二中二。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选二中二'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true},show_str : 'X] X',code_sp : ',',methodid : 500,name:'任选三中三',methoddesc:'从01-11中，选取3个及以上的号码进行投注，每注需至少包括1个胆码及2个拖码。',methodhelp:'从01-11共11个号码中选择3个及以上号码进行投注，每注需至少包括1个胆码及2个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',methodexample:'投注方案：胆码 08，托码 06 11<br>开奖号码：06 08 11 09 02，即中任选三中三。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选三中三'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true},show_str : 'X] X',code_sp : ',',methodid : 502,name:'任选四中四',methoddesc:'从01-11中，选取4个及以上的号码进行投注，每注需至少包括1个胆码及3个拖码。',methodhelp:'从01-11共11个号码中选择4个及以上号码进行投注，每注需至少包括1个胆码及3个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',methodexample:'投注方案：胆码 08，托码 06 09 11 <br>开奖号码：06 08 11 09 02，即中任选四中四。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选四中四'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true},show_str : 'X] X',code_sp : ',',methodid : 504,name:'任选五中五',methoddesc:'从01-11中，选取5个及以上的号码进行投注，每注需至少包括1个胆码及4个拖码。',methodhelp:'从01-11共11个号码中选择5个及以上号码进行投注，每注需至少包括1个胆码及4个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',methodexample:'投注方案：胆码 08，托码 02 06 09 11 <br>开奖号码：06 08 11 09 02，即中任选五中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选五中五'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true},show_str : 'X] X',code_sp : ',',methodid : 506,name:'任选六中五',methoddesc:'从01-11中，选取6个及以上的号码进行投注，每注需至少包括1个胆码及5个拖码。',methodhelp:'从01-11共11个号码中选择6个及以上号码进行投注，每注需至少包括1个胆码及5个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',methodexample:'投注方案：胆码 08，托码 02 05 06 09 11<br>开奖号码：06 08 11 09 02，即中任选六中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选六中五'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true},show_str : 'X] X',code_sp : ',',methodid : 508,name:'任选七中五',methoddesc:'从01-11中，选取7个及以上的号码进行投注，每注需至少包括1个胆码及6个拖码。',methodhelp:'从01-11共11个号码中选择7个及以上号码进行投注，每注需至少包括1个胆码及6个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',methodexample:'投注方案：胆码 08，托码 01 02 05 06 09 11<br>开奖号码：06 08 11 09 02，即中任选七中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选七中五'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'拖码', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex : 5,isButton: true,isDanTuo : true},show_str : 'X] X',code_sp : ',',methodid : 510,name:'任选八中五',methoddesc:'从01-11中，选取8个及以上的号码进行投注，每注需至少包括1个胆码及7个拖码。',methodhelp:'从01-11共11个号码中选择8个及以上号码进行投注，每注需至少包括1个胆码及7个拖码。只要当期顺序摇出的5个号码中包含所选单注号码，即为中奖。',methodexample:'投注方案：胆码 08，托码 01 02 03 05 06 09 11 <br>开奖号码：06 08 11 09 02，即中任选八中五。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'任选八中五'}]},
	{title:'胆码玩法',label:[
//		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'胆中', no:'1-1|1-2|1-3|1-4|1-5|2-2|2-3|2-4|2-5|3-3|3-4|3-5|4-4|4-5|5-5', place:1, cols:1, isSmall:true},{title:'跨度', no:'4|5|6|7|8|9|10', place:2, cols:1},{title:'和尾', no:'0|1|2|3|4|5|6|7|8|9', place:3, cols:1},{title:'和值', no:'15-19|20-25|26-34|35-40|41-45', place:4, cols:1, isRange:true},{title:'奇偶', no:'5:0|4:1|3:2|2:3|1:4|0:5', place:5, cols:1, isRange:true},{title:'大小', no:'5:0|4:1|3:2|2:3|1:4|0:5', place:6, cols:1, isRange:true}],noBigIndex : 5,isButton: false, isDm:true},show_str : 'X,X,X,X,X,X,X',code_sp : ',',methodid : 512,name:'五码胆码',methoddesc:'从胆码中至少选择一个号码生成注数。',methodhelp:'从胆码中至少选择一个号码生成注数。投注内容的条件只要符号开奖号码，即可中奖。',methodexample:'投注方案：胆码1；开奖号码：58123，即中五码胆码。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:0,numcount:0,defaultposition:'00000',desc:'五码胆码'},
//		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'胆中', no:'1-1|1-2|1-3|1-4|2-2|2-3|2-4|3-3|3-4|4-4', place:1, cols:1, isSmall:true},{title:'跨度', no:'3|4|5|6|7|8|9|10', place:2, cols:1},{title:'和尾', no:'0|1|2|3|4|5|6|7|8|9', place:3, cols:1},{title:'和值', no:'10-14|15-20|21-27|28-33|34-38', place:4, cols:1, isRange:true},{title:'奇偶', no:'4:0|3:1|2:2|1:3|0:4', place:5, cols:1, isRange:true},{title:'大小', no:'4:0|3:1|2:2|1:3|0:4', place:6, cols:1, isRange:true}],noBigIndex : 5,selPosition: true,isButton: false, isDm:true},show_str : 'X,X,X,X,X,X,X',code_sp : ',',methodid : 513,name:'任四胆码',methoddesc:'从第一位、第二位、第三位、第四位、第五位中至少选择四位，从胆码中至少选择一个号码生成注数。',methodhelp:'从第一位、第二位、第三位、第四位、第五位中至少选择四位，从胆码中至少选择一个号码生成注数。投注内容的条件只要符合开奖号码，即可中奖。',methodexample:'投注方案：胆码1；开奖号码：1234，即中任四胆码。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:4,defaultposition:'01111',desc:'任四胆码'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'胆中', no:'1-1|1-2|1-3|2-2|2-3|3-3', place:1, cols:1, isSmall:true},{title:'跨度', no:'2|3|4|5|6|7|8|9|10', place:2, cols:1},{title:'和尾', no:'0|1|2|3|4|5|6|7|8|9', place:3, cols:1},{title:'和值', no:'6-9|7-12|13-20|21-26|27-30', place:4, cols:1, isRange:true},{title:'奇偶', no:'3:0|2:1|1:2|0:3', place:5, cols:1, isRange:true},{title:'大小', no:'3:0|2:1|1:2|0:3', place:6, cols:1, isRange:true}],noBigIndex : 5,selPosition: true,isButton: false, isDm:true},show_str : 'X,X,X,X,X,X,X',code_sp : ',',methodid : 514,name:'任三胆码',methoddesc:'从第一位、第二位、第三位、第四位、第五位中至少选择三位，从胆码中至少选择一个号码生成注数。',methodhelp:'从第一位、第二位、第三位、第四位、第五位中至少选择三位，从胆码中至少选择一个号码生成注数。投注内容的条件只要符合开奖号码，即可中奖。',methodexample:'投注方案：胆码1；开奖号码：123，即中任三胆码。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:3,defaultposition:'00111',desc:'任三胆码'},
		{selectarea:{type: 'digital',layout : [{title:'胆码', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'胆中', no:'1-1|1-2|2-2', place:1, cols:1, isSmall:true},{title:'跨度', no:'1|2|3|4|5|6|7|8|9|10', place:2, cols:1},{title:'和尾', no:'0|1|2|3|4|5|6|7|8|9', place:3, cols:1},{title:'和值', no:'3-5|6-9|10-14|15-18|19-21', place:4, cols:1, isRange:true},{title:'奇偶', no:'2:0|1:1|0:2', place:5, cols:1, isRange:true},{title:'大小', no:'2:0|1:1|0:2', place:6, cols:1, isRange:true}],noBigIndex : 5,selPosition: true,isButton: false, isDm:true},show_str : 'X,X,X,X,X,X,X',code_sp : ',',methodid : 515,name:'任二胆码',methoddesc:'从第一位、第二位、第三位、第四位、第五位中至少选择二位，从胆码中至少选择一个号码生成注数。',methodhelp:'从第一位、第二位、第三位、第四位、第五位中至少选择二位，从胆码中至少选择一个号码生成注数。投注内容的条件只要符合开奖号码，即可中奖。',methodexample:'投注方案：胆码1；开奖号码：12，即中任二胆码。',prize:{1:'1700.00'},dyprize:[],modes:[{modeid:1,name:'\u5143',rate:1},{modeid:2,name:'\u89d2',rate:0.1},{modeid:3,name:'\u5206',rate:0.01}],maxcodecount:0,isrx:1,numcount:2,defaultposition:'00011',desc:'任二胆码'}]}];