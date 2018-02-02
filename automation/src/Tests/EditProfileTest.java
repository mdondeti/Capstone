package Tests;

import static org.testng.Assert.assertEquals;
import static org.testng.Assert.assertTrue;
import static org.testng.Assert.fail;

import java.io.FileInputStream;
import java.sql.Driver;
import java.util.ArrayList;
import java.util.List;

import org.testng.asserts.*;

import org.apache.poi.ss.usermodel.CellType;
import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.junit.BeforeClass;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;
import org.testng.annotations.*;
import Repos.RegisterPage;
import junit.framework.Assert;
import Repos.EditProfilePage;
import org.testng.annotations.*;
import Repos.*;


public class EditProfileTest{



	WebDriver driver ;

	static XSSFWorkbook workBook; 
	static XSSFSheet sheet;
	static XSSFRow row;
	static int i=0;
	static int j=0;
	static Object[][] DataCellValues;


	@DataProvider(name="editProfile")
	//@Test
	public static Object[][] dataInputFromExcel() throws Exception
	{
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("Edit");

		int k=sheet.getLastRowNum();//get the number of rows

		int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row

		//define a string type two dimensional array
		DataCellValues = new Object[k+1][l];
		for(i=0;i<=k;i++)
		{
			row= sheet.getRow(i);
			for(j=0;j<l-1;j++)
			{
				XSSFCell cell= row.getCell(j);	
				if(row.getCell(j)==null)
				{
					DataCellValues[i][j]="";
				}
				else
				{
					DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
				}


			}
		}
		return DataCellValues;

	}

	//	@org.testng.annotations.BeforeTest
	//	public void beforeTest()
	//	{
	//		LoginPage.GoToPage(driver);
	//		LoginPage.LoginAsAdmin(driver);
	//	}

	//LoginPage login = new LoginPage();


	//	@Test
	//	public void testData()
	//	{
	//		//EditProfilePage editprofile = new EditProfilePage();
	//		EditProfilePage.GoToPage(driver);
	//		String detailsBeforeEdit [] = EditProfilePage.getDetails(driver);
	//		for (int i=0; i<detailsBeforeEdit.length;i++)
	//		{
	//			System.out.println(detailsBeforeEdit[i]);
	//		}
	//
	//	}




	@Test(dataProvider="editProfile")
	public void AssignValues(String Email,String password,String RFName,String RLName,String RPhoneNo, String Rdep,
			String Eemail,String Edepartment,String EFName,
			String ELname,String EcontactNo,String EoldPass,String Enewpass, String EconfirmPasssword,String value) throws Exception
	{

		driver = new FirefoxDriver();
		LoginPage.GoToPage(driver);
		LoginPage.UserName(driver).sendKeys(Email);
		LoginPage.Password(driver).sendKeys(password);
		LoginPage.Submit(driver).click();		
		layoutPage.dropdown(driver).click();
		layoutPage.editProfile(driver).click();
		//assertEquals(EditProfilePage.editEmail(driver).getText(), Email);





		String detailsBeforeEdit [] = EditProfilePage.getDetails(driver);
		for (int i=0; i<detailsBeforeEdit.length;i++)
		{
			System.out.println(detailsBeforeEdit[i]+i);
		}

		assertEquals(detailsBeforeEdit[0], Email);

		assertEquals(detailsBeforeEdit[1], RFName);

		assertEquals(detailsBeforeEdit[2], RLName);
		if(RPhoneNo.length()>0)
		{
			assertEquals(detailsBeforeEdit[3], RPhoneNo);
		}

		if(EditProfilePage.editDepartment(driver).getText().length()>0)
		{
			//String Rdep=EditProfilePage.editDepartment(driver).getText();
			assertEquals(detailsBeforeEdit[4],Rdep);
		}

		System.out.println(detailsBeforeEdit[5]);
		System.out.println(detailsBeforeEdit[6]);
		System.out.println(detailsBeforeEdit[7]);

		assertEquals(detailsBeforeEdit[5].isEmpty(), true);
		assertEquals(detailsBeforeEdit[6].isEmpty(), true);
		assertEquals(detailsBeforeEdit[7].isEmpty(), true);

		//try changing the values of email 
		EditProfilePage.editEmail(driver).sendKeys(Eemail);
		assertEquals(EditProfilePage.editEmail(driver).getAttribute("value"), Email);
		//clear first name and edit it
		EditProfilePage.editFirstName(driver).clear();
		EditProfilePage.editFirstName(driver).sendKeys(EFName);

		//clear last name and edit it
		EditProfilePage.editLastName(driver).clear();
		EditProfilePage.editLastName(driver).sendKeys(ELname);
		//clear contact no and edit it
		EditProfilePage.editContactNo(driver).clear();
		EditProfilePage.editContactNo(driver).sendKeys(EcontactNo);
		//clear department and edit it
		EditProfilePage.editDepartment(driver).clear();
		EditProfilePage.editDepartment(driver).sendKeys(Edepartment);
		//old password
		EditProfilePage.oldPassword(driver).sendKeys(EoldPass);

		//new pass
		EditProfilePage.newPassword(driver).sendKeys(Enewpass);

		//confirm pass
		EditProfilePage.confirmNewPassword(driver).sendKeys(EconfirmPasssword);

		//check if firstname or last name is empty
		Thread.sleep(1000);
		EditProfilePage.Submit(driver).click();	
		Thread.sleep(1000);
		if(!(EFName.length()>0))
		{
			assertEquals(EditProfilePage.FNameAlert(driver).isDisplayed(), true);
			return;
		}
		Thread.sleep(1000);
		if(!(ELname.length()>0))
		{
			assertEquals(EditProfilePage.LNameAlert(driver).isDisplayed(), true);
			return;
		}

		//if contact exxists then checck if the contact no is greater than 10
		Thread.sleep(1000);
		System.out.println(EcontactNo.length()+"cl");
		if(EcontactNo.length()>0 &&   EcontactNo.length()!=10)
		{
			assertEquals(EditProfilePage.contactAlert(driver).isDisplayed(), true);
			return;
		}
		Thread.sleep(1000);
		
		if((EconfirmPasssword.length()>0) || (Enewpass.length()>0) || (EoldPass.length()>0))
		{
			System.out.println("got in cl");
			if(EconfirmPasssword!=Enewpass)
			{
				assertEquals(EditProfilePage.passwordError(driver).isDisplayed(), true);
				return;
			}

			if(EoldPass!=password)
			{
				System.out.println("old current missmatch");
				assertEquals(EditProfilePage.OldCurrentAlert(driver).isDisplayed(), true);
				return;
			}

			if(EconfirmPasssword.length()<6 || Enewpass.length()<6)
			{
				assertEquals(EditProfilePage.passwordError(driver).isDisplayed(), true);
				return;
			}	
			if((EoldPass.length()>0) && ((Enewpass.length()<0) || EconfirmPasssword.length()<0))
			{
				assertEquals(EditProfilePage.NewPasswordAlert(driver).isDisplayed(), true);
				return;
			}
		}
		Thread.sleep(5000);


		//EditProfilePage.BackToDash(driver).click();


		//EditProfilePage.GoToPage(driver);
		//check if message is displayed when password and confirm pass



		//try logout and login using new password set
		if(EconfirmPasssword==Enewpass && password==EoldPass && driver.getPageSource().equals("Profile updated successfully.")) {
			System.out.println("got in here");

			layoutPage.dropdown(driver).click();
			layoutPage.logout(driver).click();
			LoginPage.UserName(driver).sendKeys(Email);
			LoginPage.Password(driver).sendKeys(Enewpass);
			assertEquals(driver.findElement(By.id("role")).isDisplayed(), true);

	        System.out.println("after edit");
			String detailsAfterEdit [] = EditProfilePage.getDetails(driver);
			assertEquals(detailsAfterEdit[0], Email);
			assertEquals(detailsAfterEdit[1], EFName);
			assertEquals(detailsAfterEdit[2], ELname);
			assertEquals(detailsAfterEdit[3], EcontactNo);
			assertEquals(detailsAfterEdit[4], Edepartment);
			assertEquals(detailsAfterEdit[5],"");
			assertEquals(detailsAfterEdit[6],"");
			assertEquals(detailsAfterEdit[7],"");




			driver.close();



		} 


	}
}
