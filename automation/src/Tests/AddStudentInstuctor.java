
package Tests;
import Repos.*;
import java.sql.Driver;
import java.util.concurrent.TimeUnit;

import org.junit.Test;
import org.openqa.selenium.*;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.htmlunit.HtmlUnitDriver;
import org.openqa.selenium.support.ui.SystemClock;
import org.openqa.selenium.Keys;


import Repos.AddStudentInst;
import Repos.LoginPage;
import net.bytebuddy.implementation.bind.annotation.Super;

public class AddStudentInstuctor extends BaseTest {

	public AddStudentInstuctor() {
		super();		
	}
	
	
	@Test
	public void VerifyAddStudent() {
		
		LoginPage.GoToPage(driver);
		LoginPage.UserName(driver).sendKeys("admin@wechart.com");
		LoginPage.Password(driver).sendKeys("wechartadmin");
		LoginPage.Submit(driver).click();
		AddStudentInst.GoToPage(driver);
		AddStudentInst.AddNew(driver).click();
		System.out.println("got here");
	}
		
		
		
	
		
		
		
		
		
		
		
		
		
//		LoginPage.LoginAsAdmin(dr);
		
//		
//			//ExcelTest ex = new ExcelTest();
//			//dr.get("http://localhost/wechart/public/AddStudentEmails");
//			//dr.findElement(By.id("AddStudentEmails")).click();	
//		AddStudentInst.AddStudentButton(dr).click();
//		AddStudentInst.EnterEmailAddress(dr).sendKeys("Harsha@gmail.com");
//			
//		/**dr.findElement(By.xpath("//button[@type = 'submit']")).click();
//		dr.get("http://localhost/wechart/public/AddMoreStudentEmails");
//		dr.get("http://localhost/wechart/public/AddMoreStudentEmails");
//		dr.get("http://localhost/wechart/public/AddMoreStudentEmails");
//		dr.get("http://localhost/wechart/public/RemoveStudentEmails");
//		dr.get("http://localhost/wechart/public/RemoveStudentEmails");
//		dr.findElement(By.xpath(".//*[@id='email[]']")).sendKeys("Harsha@gmail.com");
//		dr.findElement(By.xpath("(.//*[@id='email[]'])[2]")).sendKeys("Varun@gmail.com"); */
//		
//				//WebElement EnterEmail = dr.findElement(By.id("email"));
//				//EnterEmail.sendKeys("Harsha@gmail.com");
//		dr.findElement(By.xpath("//button[@type = 'submit']")).click();
//		dr.get("http://localhost/wechart/public/home");
//		dr.get("http://localhost/wechart/public/AddStudentEmails");
//		dr.findElement(By.id("email[]")).sendKeys("Varun@gmail.com");
//		dr.findElement(By.xpath("//button[@type = 'submit']")).click();
//		dr.get("http://localhost/wechart/public/home");
//		
//		dr.get("http://localhost/wechart/public/AddInstructorEmails");	
//			//dr.findElement(By.id("AddInstructorEmails")).click();
//			//dr.findElement(By.xpath("//button[@type = 'submit']")).click();
//		dr.get("http://localhost/wechart/public/AddMoreInstructorEmails");
//		dr.get("http://localhost/wechart/public/AddMoreInstructorEmails");
//		dr.get("http://localhost/wechart/public/AddMoreInstructorEmails");
//		dr.get("http://localhost/wechart/public/RemoveInstructorEmails");
//		dr.get("http://localhost/wechart/public/RemoveInstructorEmails");
//		dr.findElement(By.xpath(".//*[@id='email[]']")).sendKeys("Verma@gmail.com");
//		dr.findElement(By.xpath("(.//*[@id='email[]'])[2]")).sendKeys("Parihar@gmail.com");
//		dr.findElement(By.xpath("//button[@type = 'submit']")).click();
//		dr.get("http://localhost/wechart/public/home");
//		dr.get("http://localhost/wechart/public/AddInstructorEmails");	
//		dr.get("http://localhost/wechart/public/AddMoreInstructorEmails");
//		dr.findElement(By.xpath(".//*[@id='email[]']")).sendKeys("Parihar@gmail.com");
//		dr.findElement(By.xpath("(.//*[@id='email[]'])[2]")).sendKeys("varun@gmail.com");
//		dr.findElement(By.xpath("//button[@type = 'submit']")).click();
//		dr.get("http://localhost/wechart/public/home");
//		
//		dr.close();


	//@Test
	public void AddMultipleStudents() {
		
	}
}
