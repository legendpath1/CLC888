(function(g) {
	if (/^1.2/.test(g.fn.jquery) || /^1.1/.test(g.fn.jquery)) {
		alert("requires jQuery v1.3 or later!  You are using v" + g.fn.jquery);
		return
	}
	g.blockUI_lang = {
		button_sure : "\u786e&nbsp;\u5b9a",
		button_cancel : "\u53d6\u6d88",
		button_upload : "\u8f7d\u5165\u6587\u4ef6",
		button_uploading : "\u6b63\u5728\u8f7d\u5165....",
		button_uploadend : "\u5b8c\u6210",
		title_warn : "\u6e29\u99a8\u63d0\u793a",
		title_confirm : "\u6e29\u99a8\u63d0\u793a",
		title_upload : "Ajax Upload",
		desc_updefaultmsg : "\u8bf7\u9009\u62e9\u4f60\u8981\u8f7d\u5165\u7684\u6587\u4ef6",
		desc_uploaderror : "\u6587\u4ef6\u683c\u5f0f\u9519\u8bef\uff0c\u53ea\u652f\u6301[%str%]\u7c7b\u578b\u7684\u6587\u4ef6",
		desc_uploadingerror : "\u8f7d\u5165\u6587\u4ef6\u5931\u8d25,\u8bf7\u91cd\u8bd5",
		img_dir : pri_imgserver + "/images/comm/"
	};
	g.blockUI = function(o) {
		e(window, o)
	};
	g.unblockUI = function(o) {
		f(window, o)
	};
	g.fn.block = function(o) {
		return this.unblock( {
			fadeOut : 0
		}).each(function() {
			if (g.css(this, "position") == "static") {
				this.style.position = "relative"
			}
			if (g.browser.msie) {
				this.style.zoom = 1
			}
			e(this, o)
		})
	};
	g.fn.unblock = function(o) {
		return this.each(function() {
			f(this, o)
		})
	};
	g.dialogBox = function(u, t, r, o, q) {
		t = (t && t.length > 1) ? t : g.blockUI_lang.title_warn;
		u = u ? u : undefined;
		r = parseInt(r, 10);
		r = (isNaN(r) || r < 10) ? 300 : r;
		o = o === false ? false : true;
		q = q ? q : window;
		if (u == undefined) {
			return
		}
		var p = m( {
			width : r,
			isbottom : false,
			title : t,
			msg : u,
			ismsgcenter : o
		});
		$html = g(p);
		if (q == window) {
			g.blockUI( {
				message : $html,
				fadeInTime : 0,
				fadeOutTime : 0,
				overlayCSS : {
					backgroundColor : "#FFFFFF",
					opacity : 0.4
				}
			})
		} else {
			q.block( {
				message : $html,
				fadeInTime : 0,
				fadeOutTime : 0,
				overlayCSS : {
					backgroundColor : "#FFFFFF",
					opacity : 0.4
				}
			})
		}
		g("#block_close", $html).click(function() {
			if (q == window) {
				g.unblockUI( {
					fadeInTime : 0,
					fadeOutTime : 0
				})
			} else {
				q.unblock( {
					fadeInTime : 0,
					fadeOutTime : 0
				})
			}
		}).mouseover(function() {
			g(this).attr("class", "c2")
		}).mouseout(function() {
			g(this).attr("class", "c1")
		})
	};
	g.alert = function(v, u, t, r, o, q) {
		u = (u && u.length > 1) ? u : g.blockUI_lang.title_warn;
		v = v ? v : undefined;
		t = (t && typeof (t) == "function") ? t : function() {
		};
		r = parseInt(r, 10);
		r = (isNaN(r) || r < 10) ? 250 : r;
		o = o === false ? false : true;
		q = q ? q : window;
		if (v == undefined) {
			return
		}
		if (typeof (v) == "string") {
			v = v.replace(/\n/g, "<br />").replace(/\r/g, "<br />")
		}
		var p = m( {
			cl_box : "block_alert",
			width : r,
			isbottom : true,
			title : u,
			msg : v,
			ismsgcenter : o,
			bt_text : '<input type="button" value="'
					+ g.blockUI_lang.button_sure
					+ '" class="yh" id="alert_close_button" />'
		});
		$html = g(p);
		if (q == window) {
			g.blockUI( {
				message : $html,
				fadeInTime : 0,
				fadeOutTime : 0,
				overlayCSS : {
					backgroundColor : "#FFFFFF",
					opacity : 0.4
				}
			})
		} else {
			q.block( {
				message : $html,
				fadeInTime : 0,
				fadeOutTime : 0,
				overlayCSS : {
					backgroundColor : "#FFFFFF",
					opacity : 0.4
				}
			})
		}
		g("#block_close", $html).add(g("#alert_close_button", $html)).click(
				function() {
					if (q == window) {
						g.unblockUI( {
							fadeInTime : 0,
							fadeOutTime : 0,
							onUnblock : t
						})
					} else {
						q.unblock( {
							fadeInTime : 0,
							fadeOutTime : 0,
							onUnblock : t
						})
					}
				});
		g("#block_close", $html).mouseover(function() {
			g(this).attr("class", "c2")
		}).mouseout(function() {
			g(this).attr("class", "c1")
		})
	};
	g.confirm = function(q, w, x, v, o, u, t, p) {
		v = (v && v.length > 1) ? v : g.blockUI_lang.title_confirm;
		q = q ? q : undefined;
		w = (w && typeof (w) == "function") ? w : function() {
		};
		x = (x && typeof (x) == "function") ? x : function() {
		};
		o = parseInt(o, 10);
		o = isNaN(o) ? 350 : o;
		t = t ? t : "";
		u = u === false ? false : true;
		p = p ? p : window;
		if (q == undefined) {
			return
		}
		if (typeof (q) == "string") {
			q = q.replace(/\n/g, "<br />").replace(/\r/g, "<br />")
		}
		var r = m( {
			cl_box : "block_confirm",
			width : o,
			isbottom : true,
			title : v,
			msg : q,
			ismsgcenter : u,
			bt_html : t,
			bt_text : '<input type="button" value="&nbsp;&nbsp;'
					+ g.blockUI_lang.button_sure
					+ '&nbsp;&nbsp;" id="confirm_yes" style="margin-right:15px;" class="yh" /><input type="button" value="'
					+ g.blockUI_lang.button_cancel
					+ '" id="confirm_no" class="yh" />'
		});
		$html = g(r);
		if (p == window) {
			g.blockUI( {
				message : $html,
				fadeInTime : 0,
				fadeOutTime : 0,
				overlayCSS : {
					backgroundColor : "#FFFFFF",
					opacity : 0.4
				}
			})
		} else {
			p.block( {
				message : $html,
				fadeInTime : 0,
				fadeOutTime : 0,
				overlayCSS : {
					backgroundColor : "#FFFFFF",
					opacity : 0.4
				}
			})
		}
		g("#block_close", $html).add(g("#confirm_no", $html)).click(function() {
			if (p == window) {
				g.unblockUI( {
					fadeInTime : 0,
					fadeOutTime : 0,
					onUnblock : x
				})
			} else {
				p.unblock( {
					fadeInTime : 0,
					fadeOutTime : 0,
					onUnblock : x
				})
			}
		});
		g("#block_close", $html).mouseover(function() {
			g(this).attr("class", "c2")
		}).mouseout(function() {
			g(this).attr("class", "c1")
		});
		g("#confirm_yes", $html).click(function() {
			if (p == window) {
				g.unblockUI( {
					fadeInTime : 0,
					fadeOutTime : 0,
					onUnblock : w
				})
			} else {
				p.unblock( {
					fadeInTime : 0,
					fadeOutTime : 0,
					onUnblock : w
				})
			}
		})
	};
	g.ajaxUploadUI = function(p) {
		var o = {
			title : g.blockUI_lang.title_upload,
			message : g.blockUI_lang.desc_updefaultmsg,
			filetype : [ "txt", "csv", "gif", "jpg", "png" ],
			loadhtml : "loading.....",
			loadok : '<img src="' + g.blockUI_lang.img_dir
					+ 'ok.png" />&nbsp;load has already ok..',
			inputfile : "ajaxUploadFile",
			onfinish : function() {
			},
			url : "",
			dataType : "text"
		};
		p = g.extend( {}, o, p || {});
		var z = p.message;
		if (z && z != null) {
			z += "<br />"
		} else {
			z = ""
		}
		z = '<form action="'
				+ p.url
				+ '" id="block_ajaxUploadForm" method="POST" enctype="multipart/form-data" target="block_ajaxUploadIframe"><p id="block_ajaxUploadArea">'
				+ z
				+ '<input type="file" name="'
				+ p.inputfile
				+ '" id="block_ajaxUploadFile" style="width:400px;" size="50"></p></form><p id="block_ajaxUploading" style="display:none;">'
				+ p.loadhtml
				+ '</p><p id="block_ajaxUploadError" style="display:none;color:#FF0000;"></p><iframe name="block_ajaxUploadIframe" id="block_ajaxUploadIframe" style="width:0px; height:0px;display:none;"></iframe>';
		var v = m( {
			cl_box : "block_ajaxUpload",
			isbottom : true,
			title : p.title,
			msg : z,
			width : 500,
			ismsgcenter : true,
			bt_text : '<input type="button" value="'
					+ g.blockUI_lang.button_upload
					+ '" id="block_ajaxConfirm" class="yh" />'
		});
		$html = g(v);
		g.blockUI( {
			message : $html,
			fadeInTime : 0,
			overlayCSS : {
				backgroundColor : "#FFFFFF",
				opacity : 0.4
			}
		});
		g("#block_close", $html).click(function() {
			g.unblockUI( {
				fadeOutTime : 0
			})
		});
		g("#block_close", $html).mouseover(function() {
			g(this).attr("class", "c2")
		}).mouseout(function() {
			g(this).attr("class", "c1")
		});
		s = g.extend( {}, g.ajaxSettings, p);
		var w = {};
		var r = false;
		g("#block_ajaxConfirm").click(
				function() {
					filepath = g("#block_ajaxUploadFile").val();
					if (filepath == "" && filepath == null
							|| filepath.length < 1) {
						return
					}
					filetype = filepath.substr(filepath.lastIndexOf(".") + 1)
							.toLowerCase();
					if (g.inArray(filetype, p.filetype) == -1) {
						u(g.blockUI_lang.desc_uploaderror.replace("%str%",
								p.filetype.join(", ")));
						return false
					}
					t();
					if (s.timeout > 0) {
						setTimeout(function() {
							if (!r) {
								x("timeout")
							}
						}, s.timeout)
					}
					try {
						var A = g("#block_ajaxUploadForm");
						g(A).attr("method", "POST");
						if (A.encoding) {
							A.encoding = "multipart/form-data"
						} else {
							A.enctype = "multipart/form-data"
						}
						g(A).submit()
					} catch (B) {
						y(g.blockUI_lang.desc_uploadingerror);
						g.handleError(s, w, "error", B)
					}
					if (window.attachEvent) {
						document.getElementById("block_ajaxUploadIframe")
								.attachEvent("onload", x)
					} else {
						document.getElementById("block_ajaxUploadIframe")
								.addEventListener("load", x, false)
					}
					return {
						abort : function() {
						}
					}
				});
		function u(A) {
			g("#block_ajaxUploadError").html(A).show().delay(3000).fadeOut(400)
		}
		function y(A) {
			g("#block_ajaxConfirm").val(g.blockUI_lang.button_upload).attr(
					"disabled", false);
			g("#block_ajaxUploading").hide();
			g("#block_ajaxUploadArea").show();
			u(A)
		}
		function t() {
			r = false;
			g("#block_ajaxConfirm").val(g.blockUI_lang.button_uploading).attr(
					"disabled", true);
			g("#block_ajaxUploadArea").hide();
			g("#block_ajaxUploading").show();
			if (s.global && !g.active++) {
				g.event.trigger("ajaxStart")
			}
		}
		function x(A) {
			var C = document.getElementById("block_ajaxUploadIframe");
			try {
				if (C.contentWindow) {
					w.responseText = C.contentWindow.document.body ? C.contentWindow.document.body.innerHTML
							: null;
					w.responseXML = C.contentWindow.document.XMLDocument ? C.contentWindow.document.XMLDocument
							: C.contentWindow.document
				} else {
					if (C.contentDocument) {
						w.responseText = C.contentDocument.document.body ? C.contentDocument.document.body.innerHTML
								: null;
						w.responseXML = C.contentDocument.document.XMLDocument ? C.contentDocument.document.XMLDocument
								: C.contentDocument.document
					}
				}
			} catch (E) {
				y(g.blockUI_lang.desc_uploadingerror);
				g.handleError(s, w, null, E)
			}
			if (w || A == "timeout") {
				r = true;
				var B;
				try {
					B = A != "timeout" ? "success" : "error";
					if (B != "error") {
						var D = q(w, s.dataType);
						g("#block_ajaxUploading").html(p.loadok);
						g("#block_ajaxConfirm").val(
								g.blockUI_lang.button_uploadend).attr(
								"disabled", false).die("click").click(
								function() {
									g.unblockUI( {
										fadeOutTime : 0,
										onUnblock : p.onfinish
									})
								});
						g("#block_close", $html).die("click").click(function() {
							g.unblockUI( {
								fadeOutTime : 0,
								onUnblock : p.onfinish
							})
						});
						if (s.success) {
							s.success(D, B)
						}
						if (s.global) {
							g.event.trigger("ajaxSuccess", [ w, s ])
						}
					} else {
						y(g.blockUI_lang.desc_uploadingerror);
						g.handleError(s, w, B)
					}
				} catch (E) {
					y(g.blockUI_lang.desc_uploadingerror);
					B = "error";
					g.handleError(s, w, B, E)
				}
				if (s.global) {
					g.event.trigger("ajaxComplete", [ w, s ])
				}
				if (s.global && !--g.active) {
					g.event.trigger("ajaxStop")
				}
				if (s.complete) {
					s.complete(w, B)
				}
				g(C).unbind();
				w = null
			}
		}
		function q(A, B) {
			var C = !B;
			C = (B == "xml" || C) ? A.responseXML : A.responseText;
			if (B == "script") {
				g.globalEval(C)
			}
			if (B == "json") {
				if (/^[\],:{}\s]*$/
						.test(C
								.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,
										"@")
								.replace(
										/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
										"]")
								.replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) {
					if (window.JSON && window.JSON.parse) {
						C = window.JSON.parse(C)
					} else {
						C = (new Function("return " + C))()
					}
				} else {
					throw "Invalid JSON: " + C
				}
			}
			return C
		}
	};
	function m(p) {
		var q = {
			cl_box : "block_box",
			cl_title : "block_title",
			cl_close : "block_title_close",
			cl_c_box : "block_content_box",
			cl_content : "block_content",
			cl_bottom : "block_bottom",
			ismsgcenter : false,
			isbottom : false,
			title : "tip",
			msg : "",
			bt_text : "",
			bt_html : "",
			width : 0
		};
		p = g.extend( {}, q, p || {});
		p.width = p.width < 50 ? 300 : p.width;
		var o = '<div class=mdl style="width:' + p.width
				+ 'px;"><h3 id="block_draghandler">' + p.title
				+ '</h3><table style="width:100%;"><tr><td '
				+ (p.ismsgcenter ? 'style="text-align:center;"' : "") + ">"
				+ p.msg + "</td></tr>";
		if (p.isbottom) {
			if (p.bt_html.length > 10) {
				o += '<tr><td><table><tr><td style="padding-top:4px;">'
						+ p.bt_html
						+ '</td><td style="text-align:right;float:right;">'
						+ p.bt_text + "</td></tr></table></td></tr></table>"
			} else {
				o += '<tr><td style="text-align:center;">' + p.bt_text
						+ "</td></tr></table>"
			}
		} else {
			o += "</table>"
		}
		o += '<div class=mdl_t_l></div><div class=mdl_t_c id="block_draghandler"><span></span></div><div class=mdl_t_r></div><div class=mdl_c_l><span></span></div><div class=mdl_c_r><span></span></div><div class=mdl_b_l></div><div class=mdl_b_c><span></span></div><div class=mdl_b_r></div><div class=mdl_clo><img src="'
				+ g.blockUI_lang.img_dir
				+ 't.gif" class=c1 id="block_close" style="cursor:pointer;"></div>';
		return o
	}
	g.blockUI.defaults = {
		message : "<h1>Please wait...</h1>",
		baseZ : 2000,
		fadeInTime : 200,
		fadeOutTime : 400,
		timeout : 0,
		overlayCSS : {
			backgroundColor : "#CCCCCC",
			opacity : 0.6,
			cursor : "default"
		},
		centerX : true,
		centerY : true,
		showOverlay : true,
		focusInput : true,
		onUnblock : null,
		quirksmodeOffsetHack : 4
	};
	g.blockUI.version = "2.0.0";
	g.blockUI.params = {
		pageBlock : null,
		pageBlockEls : []
	};
	var h = document.documentMode || 0;
	var c = g.browser.msie && ((g.browser.version < 8 && !h) || h < 8);
	var d = g.browser.msie && /MSIE 6.0/.test(navigator.userAgent) && !h;
	var k = c
			&& (!g.boxModel || g("object,embed", full ? null : el).length > 0);
	function e(o, A) {
		var u = o == window ? true : false;
		var B = (A && A.message !== undefined) ? A.message
				: g.blockUI.defaults.message;
		A = g.extend( {}, g.blockUI.defaults, A || {});
		if (u && g.blockUI.params.pageBlock) {
			f(window, {
				fadeOut : 0
			})
		}
		if (B && typeof (B) != "string" && (B.parentNode || B.jquery)) {
			var D = B.jquery ? B[0] : B;
			var K = {};
			g(o).data("blockUI.history", K);
			K.el = D;
			K.parent = D.parentNode;
			K.display = D.style.display;
			K.position = D.style.position;
			if (K.parent) {
				K.parent.removeChild(D)
			}
		}
		var v = A.baseZ;
		var x = "display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0;";
		var C = "display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0;background-color:#CCCCCC;opacity:0.7;cursor:default;";
		var I = "display:none;padding:0;margin:0;top:40%;left:35%;text-align:center;color:#000000;border:0px;";
		var H = g.browser.msie ? g('<iframe id="JS_blockUI" style="z-index:'
				+ (v++) + ";" + x + '"></iframe>')
				: g('<div id="JS_blockUI" style="z-index:' + (v++) + ";" + x
						+ '"></div>');
		var G = g('<div id="JS_blockOverlay" style="z-index:' + (v++) + ";" + C
				+ '"></div>');
		var F = u ? g('<div id="JS_blockPage" style="z-index:' + v
				+ ";position:fixed;" + I + '"></div>')
				: g('<div id="JS_blockElement" style="z-index:' + v
						+ ";position:absolute;" + I + '"></div>');
		G.css(A.overlayCSS).css("position", u ? "fixed" : "absolute");
		if (g.browser.msie || A.forceIframe) {
			H.css("opacity", 0)
		}
		var r = [ H, G, F ];
		var J = u ? g("body") : g(o);
		g.each(r, function() {
			this.appendTo(J)
		});
		if (d || k) {
			if (u && g.support.boxModel) {
				g("html,body").css("height", "100%")
			}
			if ((d || !g.boxModel) && !u) {
				var y = j(o, "borderTopWidth");
				var E = j(o, "borderLeftWidth");
				var q = y ? "(0 - " + y + ")" : 0;
				var w = E ? "(0 - " + E + ")" : 0
			}
			g
					.each(
							[ H, G, F ],
							function(t, N) {
								var z = N[0].style;
								z.position = "absolute";
								if (t < 2) {
									u ? z
											.setExpression(
													"height",
													"Math.max(document.body.scrollHeight, document.body.offsetHeight) - (jQuery.boxModel?0:"
															+ A.quirksmodeOffsetHack
															+ ') + "px"')
											: z
													.setExpression("height",
															'this.parentNode.offsetHeight + "px"');
									u ? z
											.setExpression(
													"width",
													'jQuery.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"')
											: z
													.setExpression("width",
															'this.parentNode.offsetWidth + "px"');
									if (w) {
										z.setExpression("left", w)
									}
									if (q) {
										z.setExpression("top", q)
									}
								} else {
									if (A.centerY) {
										if (u) {
											z
													.setExpression(
															"top",
															'(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (blah = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"')
										}
										z.marginTop = 0
									} else {
										if (!A.centerY && u) {
											var L = 0;
											var M = "((document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "
													+ L + ') + "px"';
											z.setExpression("top", M)
										}
									}
								}
							})
		}
		if (B) {
			F.append(B);
			if (B.jquery || B.nodeType) {
				g(B).show()
			}
		}
		if (g.browser.msie && A.showOverlay) {
			H.show()
		}
		if (A.fadeInTime) {
			if (A.showOverlay) {
				G.fadeIn(A.fadeInTime)
			}
			if (B) {
				F.fadeIn(A.fadeInTime)
			}
		} else {
			if (A.showOverlay) {
				G.show()
			}
			if (B) {
				F.show()
			}
		}
		if (u) {
			l(F[0]);
			g.blockUI.params.pageBlock = F[0];
			g.blockUI.params.pageBlockEls = g(":input:enabled:visible", F[0]);
			if (A.focusInput) {
				setTimeout(n, 20)
			}
		} else {
			a(F[0], A.centerX, A.centerY)
		}
		if (A.timeout) {
			var p = setTimeout(function() {
				u ? g.unblockUI(A) : g(o).unblock(A)
			}, A.timeout);
			g(o).data("blockUI.timeout", p)
		}
	}
	function f(r, t) {
		var q = r == window ? true : false;
		var p = g(r);
		var u = p.data("blockUI.history");
		var v = p.data("blockUI.timeout");
		t = g.extend( {}, g.blockUI.defaults, t || {});
		if (v) {
			clearTimeout(v);
			p.removeData("blockUI.timeout")
		}
		var o = q ? g("body").children().filter("[id^='JS_block']") : g(
				"[id^='JS_block']", r);
		if (q) {
			g.blockUI.params.pageBlock = g.blockUI.params.pageBlockEls = null
		}
		if (t.fadeOutTime) {
			o.fadeOut(t.fadeOutTime);
			setTimeout(function() {
				i(o, u, t, r)
			}, t.fadeOut)
		} else {
			i(o, u, t, r)
		}
	}
	function i(o, r, q, p) {
		o.each(function(t, u) {
			if (this.parentNode) {
				this.parentNode.removeChild(this)
			}
		});
		if (r && r.el) {
			r.el.style.display = r.display;
			r.el.style.position = r.position;
			if (r.parent) {
				r.parent.appendChild(r.el)
			}
			g(p).removeData("blockUI.history")
		}
		if (typeof (q.onUnblock) == "function") {
			q.onUnblock(p, q)
		}
	}
	function j(o, q) {
		return parseInt(g.css(o, q)) || 0
	}
	function a(v, o, z) {
		var w = v.parentNode, u = v.style;
		var q = ((w.offsetWidth - v.offsetWidth) / 2) - j(w, "borderLeftWidth");
		var r = ((w.offsetHeight - v.offsetHeight) / 2)
				- j(w, "borderTopWidth");
		if (o) {
			u.left = q > 0 ? (q + "px") : "0"
		}
		if (z) {
			u.top = r > 0 ? (r + "px") : "0"
		}
	}
	function n(o) {
		if (!g.blockUI.params.pageBlockEls) {
			return
		}
		var p = g.blockUI.params.pageBlockEls[o === true ? g.blockUI.params.pageBlockEls.length - 1
				: 0];
		if (p) {
			p.focus()
		}
	}
	function l(o) {
		var p = g(window).height() / 2 - g(o).height() / 2
				+ (d ? document.documentElement.scrollTop : 0);
		var q = g(window).width() / 2 - g(o).width() / 2
				+ (d ? document.documentElement.scrollLeft : 0);
		g(o).css( {
			left : q + "px",
			top : p + "px"
		})
	}
	function b(q, p, o) {
		if (g.inArray(o, [ "auto", "hidden", "inherit", "scroll", "visible" ]) == -1) {
			o = "auto"
		}
		if (g(q).height() > p) {
			g(q).css( {
				height : p,
				overflow : o,
				"overflow-x" : "hidden"
			})
		}
	}
	g.fn.openFloat = function(v, p, o, w) {
		if (g("#JS_openFloat").length > 0) {
			g(this).closeFloat();
			return
		}
		o = parseInt(o, 10);
		w = parseInt(w, 10);
		o = isNaN(o) ? null : o;
		w = isNaN(w) ? null : w;
		var u = g(this).offset();
		var t = u.left;
		var r = u.top + g(this).height();
		if (o != null) {
			t = o
		}
		if (w != null) {
			r = w
		}
		var q = g('<div id="JS_openFloat" style="display:none;position:absolute;z-index:200;left:'
				+ t + "px;top:" + r + 'px"></div>');
		q.addClass(p);
		q.append(v);
		if (v.jquery || v.nodeType) {
			g(v).show()
		}
		q.appendTo(g("body"));
		q.show();
		q.css("top", (u.top - q.height() - 7) + "px")
	};
	g.fn.closeFloat = function() {
		g("#JS_openFloat").remove()
	}
})(jQuery);
