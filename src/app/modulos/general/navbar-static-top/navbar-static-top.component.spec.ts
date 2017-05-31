import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NavbarStaticTopComponent } from './navbar-static-top.component';

describe('NavbarStaticTopComponent', () => {
  let component: NavbarStaticTopComponent;
  let fixture: ComponentFixture<NavbarStaticTopComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NavbarStaticTopComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NavbarStaticTopComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
