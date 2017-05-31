import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

// Helpers
import { Helper } from './helpers/helper';

// Servicios
import { AutenticacionService } from './modulos/kseg/servicios/autenticacion.service';
import { UsusuService } from './modulos/kseg/servicios/ususu.service';

// Componentes
import { AppComponent } from './app.component';
import { IngresarComponent } from './modulos/kseg/ingresar/ingresar.component';
import { NavbarDefaultComponent } from './modulos/general/navbar-default/navbar-default.component';
import { NavbarStaticTopComponent } from './modulos/general/navbar-static-top/navbar-static-top.component';
import { DashboardHeaderComponent } from './modulos/general/dashboard-header/dashboard-header.component';
import { RightSidebarComponent } from './modulos/general/right-sidebar/right-sidebar.component';
import { SmallChatComponent } from './modulos/general/small-chat/small-chat.component';

@NgModule({
  declarations: [
    AppComponent,
    IngresarComponent,
    NavbarDefaultComponent,
    NavbarStaticTopComponent,
    DashboardHeaderComponent,
    RightSidebarComponent,
    SmallChatComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule
  ],
  providers: [ Helper, AutenticacionService, UsusuService ],
  bootstrap: [AppComponent]
})
export class AppModule { }
