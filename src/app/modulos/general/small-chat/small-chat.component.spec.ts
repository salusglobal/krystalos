import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SmallChatComponent } from './small-chat.component';

describe('SmallChatComponent', () => {
  let component: SmallChatComponent;
  let fixture: ComponentFixture<SmallChatComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SmallChatComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SmallChatComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
