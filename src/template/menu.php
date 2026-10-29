<?php
$id_rol_usuario = $_SESSION['id_rol'] ?? 0;
?>
<!--begin::Aside-->
				<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
					<!--begin::Brand-->
					<div class="aside-logo flex-column-auto" id="kt_aside_logo">
						<!--begin::Logo-->
						<a href="index.html">
							<img alt="Logo" src="assets/media/logos/demo13.svg" class="h-15px logo" />
						</a>
						<!--end::Logo-->
						<!--begin::Aside toggler-->
						<div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle me-n2" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
							<i class="ki-outline ki-double-left fs-1 rotate-180"></i>
						</div>
						<!--end::Aside toggler-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
					<div class="aside-menu flex-column-fluid">
						<!--begin::Aside Menu-->
						<div class="hover-scroll-overlay-y" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
							<!--begin::Menu-->
							<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="ki-outline ki-element-11 fs-2"></i>
										</span>
										<span class="menu-title">Catalogo de Productos</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link active" href="javascript:;" id="todos_los_productos">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Productos</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="javascript:;" id="filtro_categorias">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Filtrar por Categorías</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="ki-outline ki-address-book fs-2"></i>
										</span>
										<span class="menu-title">Mi Tienda</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="pages/user-profile/overview.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Carrito de Compras</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="pages/user-profile/projects.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Mis Pedidos y Compras Realizadas</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									
								
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="ki-outline ki-element-plus fs-2"></i>
										</span>
										<span class="menu-title">Mi Cuenta</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="account/overview.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Datos Personales</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								<!-- SECCIÓN EXCLUSIVA PARA ADMINISTRADORES (Ej: id_rol 1) -->
								 <?php if ($id_rol_usuario == 1 || $id_rol_usuario == 2): ?>
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="ki-outline ki-user fs-2"></i>
										</span>
										<span class="menu-title">Panel Principal</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
												
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="authentication/general/welcome.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Dashboard / Estadísticas de Ventas</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="ki-outline ki-abstract-39 fs-2"></i>
										</span>
										<span class="menu-title">Gestión de Tienda</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="javascript:;" id="cat_productos">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Catálogo de Productos (Crear, Editar, Listar)</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="pages/social/activity.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Catálogo de Categorías (Crear, Editar, Listar)</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->

									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="ki-outline ki-bank fs-2"></i>
										</span>
										<span class="menu-title">Ventas</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion menu-active-bg">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="pages/blog/home.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Administrar Pedidos de Clientes</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="pages/blog/post.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Control de Stock</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								<?php endif; ?>
        						<!-- Fin de sección exclusiva de administradores -->
								 <!-- SECCIÓN EXCLUSIVA PARA SUPER_ADMINISTRADORES (Ej: id_rol 1) -->
								 <?php if ($id_rol_usuario == 1): ?>
									<!--begin:Menu item-->
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-chart-pie-3 fs-2"></i>
											</span>
											<span class="menu-title">Panel Principal SA</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->
										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="pages/faq/classic.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Dashboard General del Sistema</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
										</div>
										<!--end:Menu sub-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-bucket fs-2"></i>
											</span>
											<span class="menu-title">Administración del Sistema</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->
										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="pages/pricing.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Gestión de Usuarios (Crear, Modificar Roles, Activar/Inactivar)</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="pages/pricing/table.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Catálogo de Roles</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
										</div>
										<!--end:Menu sub-->
									</div>
									<!--end:Menu item-->
								<?php endif; ?>
        						<!-- Fin de sección exclusiva de administradores -->
							</div>
							<!--end::Menu-->
						</div>
					</div>
					<!--end::Aside menu-->
				</div>
				<!--end::Aside-->